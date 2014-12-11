<?php


class Publisher extends Eloquent {
    protected $table = 'publisher';

    protected $fillable = array('name');

	public function countries(){
    	return $this->belongsToMany('Country', 'publisher_country');
	}

	public function books()
    {
        return $this->hasMany('Book');
    }

}