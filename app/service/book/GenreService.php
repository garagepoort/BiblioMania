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

    public function getAllParentGenres(){
        return Genre::where('parent_id', '=', null)->get();
    }


    public function getAllGenres(){
        return Genre::all();
    }

    public function getAllRootGenres(){
        return Genre::with("child_genres")->where('parent_id', '=', null)->get();
    }
}