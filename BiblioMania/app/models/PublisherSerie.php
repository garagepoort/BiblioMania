<?php

class PublisherSerie extends Eloquent {
    protected $table = 'publisher_serie';

    protected $fillable = array('name', 'publisher_id');

	public function books(){
    	return $this->hasMany('Book');
	}	

}