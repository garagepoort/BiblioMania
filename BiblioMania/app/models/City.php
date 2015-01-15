<?php
class City extends Eloquent {
    protected $table = 'city';

    protected $fillable = array('name', 'country_id');

	public function country(){
    	return $this->belongsTo('Country');
	}
}