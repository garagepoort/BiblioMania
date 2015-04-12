<?php

class OeuvreMapper {

    public function mapToOeuvreList($oeuvreText, $author_id){
        $oeuvreList = array();
        if (!empty($oeuvreText)) {
            $titles = explode("\n", $oeuvreText);
            foreach ($titles as $title) {
                $res = explode(" - ", $title);
                $bookFromAuthor = new BookFromAuthor();
                $bookFromAuthor->publication_year = $res[0];
                $bookFromAuthor->title = $res[1];
                $bookFromAuthor->author_id = $author_id;

                array_push($oeuvreList, $bookFromAuthor);
            }
        }
        return $oeuvreList;
    }

}