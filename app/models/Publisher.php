<?php

/**
 * @property integer id
 * @property string name
 * @property Illuminate\Database\Eloquent\Collection books
 * @property Illuminate\Database\Eloquent\Collection first_print_infos
 */
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