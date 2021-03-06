<?php

/**
 * @property integer id
 * @property string name
 * @property string code
 */
class Country extends Eloquent {
    protected $table = 'country';

    protected $fillable = array('name', 'code');
    public $timestamps = false;

    public function books(){
        return $this->hasMany('Book', 'publisher_country_id');
    }

    public function authors(){
        return $this->hasMany('Author', 'country_id');
    }

    public function first_print_infos(){
        return $this->hasMany('FirstPrintInfo', 'country_id');
    }

    public function cities(){
        return $this->hasMany('City', 'country_id');
    }
}