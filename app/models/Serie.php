<?php

class Serie extends Eloquent {
    protected $table = 'serie';

    protected $fillable = array('name');

	public function books(){
    	return $this->hasMany('Book');
	}	

}