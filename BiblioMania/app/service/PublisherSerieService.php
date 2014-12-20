<?php

class PublisherSerieService {

    public function findOrSave($name){

    	$serie = PublisherSerie::where(array('name'=> $name))->first();

        if (is_null($serie)) {
        	$serie = new PublisherSerie(array(
            	'name' => $name
        	));
        	$serie->save();
        }
       	return $serie;
    }

}