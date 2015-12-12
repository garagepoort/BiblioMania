<?php

class BookSerieService
{

    public function findOrSave($name)
    {
        $serie = Serie::where(array('name' => $name))->first();

        if (is_null($serie)) {
            $serie = new Serie(array(
                'name' => $name
            ));
            $serie->save();
        }
        return $serie;
    }

    public function getSeries()
    {
        return Serie::all();
    }

}