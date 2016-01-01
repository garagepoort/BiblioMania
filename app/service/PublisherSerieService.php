<?php

class PublisherSerieService
{

    public function findOrSave($name, $publisher_id)
    {

        $serie = PublisherSerie::where(array('name' => $name))
            ->where('publisher_id', '=', $publisher_id)
            ->first();

        if (is_null($serie)) {
            $serie = new PublisherSerie(array(
                'name' => $name,
                'publisher_id' => $publisher_id
            ));
            $serie->save();
        }
        return $serie;
    }

    public function getPublisherSeries()
    {
        return PublisherSerie::all();
    }

}