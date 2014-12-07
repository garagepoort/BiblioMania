<?php


class Genre extends Eloquent {
    protected $table = 'genre';

    protected $fillable = array('name', 
    	'parent_id'
	);

	public function parent_genre(){
    	return $this->belongsTo('Genre', 'parent_id');
	}

}