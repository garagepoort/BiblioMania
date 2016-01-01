<?php

class Publisher extends Eloquent {
    protected $table = 'publisher';

    protected $fillable = array('name', 'user_id');

	public function books()
    {
        return $this->hasMany('Book', 'publisher_id');
    }

	public function first_print_infos()
    {
        return $this->hasMany('FirstPrintInfo', 'publisher_id');
    }

	public function series()
    {
        return $this->hasMany('PublisherSerie', 'publisher_id');
    }

}