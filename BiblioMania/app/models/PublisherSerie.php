<?php

class PublisherSerie extends Eloquent {
    protected $table = 'publisher_serie';

    protected $fillable = array('name');

	public function books(){
    	return $this->hasMany('Book');
	}	

}