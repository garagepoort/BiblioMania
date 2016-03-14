<?php

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

    public function getScatterChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        $labels = array();
        $data = array();

        $builder = DB::table('book')->select($chartConfiguration->xProperty . ' as x', $chartConfiguration->yProperty . " as y");
        $builder = $this->join($builder);
        $builder =  $builder->where('user_id', '=', $userId);

        /** @var ChartCondition $condition */
        foreach($chartConfiguration->conditions as $condition){
            $builder = $builder->where($condition->name, $condition->operator, $condition->value);
        }

        $results = $builder->get();

        $values = array();
        foreach($results as $result){
            if(in_array($result->x, $labels) == false){
                array_push($labels, $result->x);
            }

            array_push($values, array("x" => $result->x, "y" => $result->y));
        }
        array_push($data, $values);

        $chartData = new ChartData($chartConfiguration->title, $chartConfiguration->type, $labels, $data);
        return $chartData;
    }

    public function getBarChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        $labels = array();
        $data = array();

        $builder = DB::table('book')->select($chartConfiguration->xProperty . ' as xProperty', DB::raw("count(*) as total"));
        $builder = $this->join($builder);
        $builder =  $builder->where('user_id', '=', $userId);

        /** @var ChartCondition $condition */
        foreach($chartConfiguration->conditions as $condition){
            $builder = $builder->where($condition->name, $condition->operator, $condition->value);
        }

        $results = $builder->groupBy($chartConfiguration->xProperty)->get();

        $values = array();
        foreach($results as $result){
            if(in_array($result->xProperty, $labels) == false){
                array_push($labels, $result->xProperty);
            }

            array_push($values, $result->total);
        }
        array_push($data, $values);

        $chartData = new ChartData($chartConfiguration->title, $chartConfiguration->type, $labels, $data);
        return $chartData;
    }

    private function join($builder){
        return $builder->join('personal_book_info', 'book_id', '=', 'book.id')
            ->join('book_author', 'book_author.book_id', '=', 'book.id')
            ->join('author', 'book_author.author_id', '=', 'author.id')
            ->join('date as publicationDate', 'book.publication_date_id', '=', 'publicationDate.id')
            ->join('reading_date', 'reading_date.personal_book_info_id', '=', 'personal_book_info.id')
            ->join('genre', 'genre.id', '=', 'book.genre_id');
    }
}