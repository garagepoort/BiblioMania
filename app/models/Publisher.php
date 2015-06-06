<?php

class Publisher extends Eloquent {
    protected $table = 'publisher';

    protected $fillable = array('name', 'user_id');

    protected $with = array('countries');

	public function countries(){
    	return $this->belongsToMany('Country', 'publisher_country');
	}

	public function books()
    {
        return $this->hasMany('Book', 'publisher_id');
    }

	public function first_print_infos()
    {
        return $this->hasMany('FirstPrintInfo', 'publisher_id');
    }

}