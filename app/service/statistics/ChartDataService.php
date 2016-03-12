<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class ChartDataService
{

    public function getChartDataFromConfiguration($userId, ChartConfiguration $chartConfiguration){
        $labels = array();
        $data = array();

        foreach($chartConfiguration->getSeries() as $serie){
            $results = DB::table('book')
                ->select($chartConfiguration->getXProperty() . ' as xProperty', $serie . ' as serieProp', DB::raw("count(genre.name) as total"))
                ->join('personal_book_info', 'book_id', '=', 'book.id')
                ->join('book_author', 'book_author.book_id', '=', 'book.id')
                ->join('author', 'book_author.author_id', '=', 'author.id')
                ->join('genre', 'genre.id', '=', 'book.genre_id')
                ->where('user_id', '=', $userId)
                ->groupBy($chartConfiguration->getXProperty(), $serie)
                ->get();

            $values = array();
            foreach($results as $result){
                if(in_array($result->xProperty, $labels) == false){
                    array_push($labels, $result->xProperty);
                }

                array_push($values, $result->total);
            }
            array_push($data, $values);
        }

        array_unique($labels);

        $chartData = new ChartData($labels, $data, $chartConfiguration->getSeries());
        return $chartData;
    }
}