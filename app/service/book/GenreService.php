<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 22/06/15
 * Time: 21:55
 */

class GenreService {

    public function getGenreByName($name){
        $genre = Genre::where("name", "=", $name)->first();
        return $genre;
    }
}