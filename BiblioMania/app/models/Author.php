<?php


class Country extends Eloquent {
    protected $table = 'author';

    protected $fillable = array('name', 'firstname', 'image'. 'date_of_death'. 'date_of_birth', 'country_id');

    public function country(){
    	return $this->belongsTo('Country');
	}

	public function awards()
    {
        return $this->belongsToMany('AuthorAward', 'author_author_award');
    }

}