<?php

class OeuvreToParameterMapper {

    public function mapToOeuvreList($oeuvreText){
        $oeuvreList = array();
        if (!empty($oeuvreText)) {
            $titles = explode("\n", $oeuvreText);
            foreach ($titles as $title) {
                $res = explode(" - ", $title);
                $bookFromAuthorParameters = new BookFromAuthorParameters(trim($res[1]), trim($res[0]));

                array_push($oeuvreList, $bookFromAuthorParameters);
            }
        }
        return $oeuvreList;
    }

    public function mapToOeuvreListWithId($oeuvreText){
        $oeuvreList = array();
        if (!empty($oeuvreText)) {
            $items = explode("\n", $oeuvreText);
            foreach ($items as $item) {
                if(!StringUtils::isEmpty($item)){
                    $res = explode(" - ", $item);
                    $id = trim($res[0]);
                    $year = trim($res[1]);
                    $title = trim($res[2]);
                    $bookFromAuthorParameters = BookFromAuthorParameters::createWithId($id, $title, $year);

                    array_push($oeuvreList, $bookFromAuthorParameters);
                }
            }
        }
        return $oeuvreList;
    }
}