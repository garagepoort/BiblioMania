<?php

use Bendani\PhpCommon\FilterService\Model\ChartConfigurationXProperty;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class ChartDataService
{

    /** @var  BookFilterManager */
    private $bookFilterManager;

    /**
     * ChartDataService constructor.
     */
    public function __construct()
    {
        $this->bookFilterManager = App::make('BookFilterManager');
    }


    public function getChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        if($chartConfiguration->type === 'BAR'){
            return $this->getBarChartDataFromConfiguration($userId, $chartConfiguration);
        }
        throw new ServiceException('No chart found for type: ' . $chartConfiguration->type);
    }

    public function getBarChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        $labels = array();

        $builder = DB::table('book')->select(DB::raw($chartConfiguration->xProperty . ' as xProperty'), DB::raw("count(*) as total"));
        $builder = $this->join($builder);
        $builder =  $builder->where('user_id', '=', $userId);

        $adapter = new AllFilterValuesFromJsonAdapter(json_decode($chartConfiguration->filters, true));
        $filterValues = $adapter->getFilters();

        foreach($filterValues as $filterValue){
            $builder =  $this->bookFilterManager->handle(FilterHandlerGroup::SQL, $filterValue, $builder);
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
            ->join('country', 'book.publisher_country_id', '=', 'country.id')
            ->join('date as publicationDate', 'book.publication_date_id', '=', 'publicationDate.id')
            ->join('reading_date', 'reading_date.personal_book_info_id', '=', 'personal_book_info.id')
            ->join('genre', 'genre.id', '=', 'book.genre_id');
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