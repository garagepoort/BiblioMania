<?php

class PublisherService {

	public function saveOrUpdate($name, $country){
		$publisher = Publisher::where('name', '=', $name)
                ->where("user_id", "=", Auth::user()->id)
	            ->first();

        if (is_null($publisher)) {
            	$publisher = new Publisher(array(
	            	'name' => $name,
            	));
                $publisher->user_id = Auth::user()->id;
            	$publisher->save();
        }
        $publisher->countries()->sync([$country->id], false);
        return $publisher;
	}
}