<?php

class PublisherService {

	public function saveOrUpdate($name, $country){
		$publisher = Publisher::where('name', '=', $name)
	            ->first();

        if (is_null($publisher)) {
            	$publisher = new Publisher(array(
	            	'name' => $name
            	));
            	$publisher->save();
        }
        $publisher->countries()->sync([$country->id], false);
        return $publisher;
	}
}