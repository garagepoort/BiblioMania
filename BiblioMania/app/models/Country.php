<?php

class Country extends Eloquent {
    protected $table = 'country';

    protected $fillable = array('name', 'code');
    public $timestamps = false;

	public function publishers(){
    	return $this->belongsToMany('Publisher', 'publisher_country');
	}
}