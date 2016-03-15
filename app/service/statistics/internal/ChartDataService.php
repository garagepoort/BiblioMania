<?php

use Bendani\PhpCommon\FilterService\Model\ChartConfigurationXProperty;

class ChartDataService
{

    public function getChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        if($chartConfiguration->type === 'BAR'){
            return $this->getBarChartDataFromConfiguration($userId, $chartConfiguration);
        }
        if($chartConfiguration->type === 'SCATTER'){
            return $this->getScatterChartDataFromConfiguration($userId, $chartConfiguration);
        }
    }

    public function getBarChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        $labels = array();

        $builder = DB::table('book')->select(DB::raw($chartConfiguration->xProperty . ' as xProperty'), DB::raw("count(*) as total"));
        $builder = $this->join($builder);
        $builder = $this->enhanceQueryBuilderBasedOnXProperty($chartConfiguration->xProperty, $builder);
        $builder =  $builder->where('user_id', '=', $userId);

        /** @var ChartCondition $condition */
        foreach($chartConfiguration->conditions as $condition){
            $builder = $builder->where($condition->name, $condition->operator, $condition->value);
        }
        $results = $builder->groupBy(DB::raw($chartConfiguration->xProperty))->get();

        list($data, $labels) = $this->createChartDataFromResult($results, $labels);

        $chartData = new ChartData($chartConfiguration->title, $chartConfiguration->type, $labels, $data);
        return $chartData;
    }

    private function join($builder){
        return $builder->join('personal_book_info', 'book_id', '=', 'book.id')
            ->join('book_author', 'book_author.book_id', '=', 'book.id')
            ->join('author', 'book_author.author_id', '=', 'author.id')
            ->join('date as publicationDate', 'book.publication_date_id', '=', 'publicationDate.id')
            ->join('genre', 'genre.id', '=', 'book.genre_id');
    }

    private function enhanceQueryBuilderBasedOnXProperty($xProperty, $builder){
        if($xProperty == ChartConfigurationXProperty::READING_DATE_YEAR){
            $builder = $builder->join('reading_date', 'reading_date.personal_book_info_id', '=', 'personal_book_info.id');
        }
        return $builder;
    }

    /**
     * @param $results
     * @param $labels
     * @return array
     */
    private function createChartDataFromResult($results, $labels)
    {
        $data = array();
        $values = array();
        foreach ($results as $result) {
            if (in_array($result->xProperty, $labels) == false) {
                array_push($labels, $result->xProperty);
            }

            array_push($values, $result->total);
        }
        array_push($data, $values);
        return array($data, $labels);
    }
}