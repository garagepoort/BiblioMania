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
            $titles = explode("\n", $oeuvreText);
            foreach ($titles as $title) {
                $res = explode(" - ", $title);
                $bookFromAuthorParameters = BookFromAuthorParameters::createWithId(trim($res[2]),trim($res[1]), trim($res[0]));

                array_push($oeuvreList, $bookFromAuthorParameters);
            }
        }
        return $oeuvreList;
    }
}