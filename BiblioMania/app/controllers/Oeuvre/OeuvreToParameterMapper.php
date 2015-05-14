<?php

class OeuvreToParameterMapper {

    public function mapToOeuvreList($oeuvreText){
        $oeuvreList = array();
        if (!empty($oeuvreText)) {
            $titles = explode("\n", $oeuvreText);
            foreach ($titles as $title) {
                $res = explode(" - ", $title);
                $bookFromAuthorParameters = new BookFromAuthorParameters($res[1], $res[0]);

                array_push($oeuvreList, $bookFromAuthorParameters);
            }
        }
        return $oeuvreList;
    }

}