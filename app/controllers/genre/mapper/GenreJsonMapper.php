<?php


class GenreJsonMapper
{
    public function mapToJson(Genre $genre)
    {
        /** @var GenreData $genreData */
        $genreData = new GenreData();
        $genreData->setLabel($genre->name);
        $genreData->setChildren($this->mapArrayToJson($genre->child_genres()->get()));
        return $genreData->toJson();
    }

    public function mapArrayToJson($genres)
    {
        $result = array();
        foreach($genres as $genre){
            array_push($result, $this->mapToJson($genre));
        }
        return $result;
    }
}