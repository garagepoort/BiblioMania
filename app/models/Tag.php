<?php

class Tag extends Eloquent {
    protected $table = 'tag';

    protected $fillable = array('name');

    public function books(){
        return $this->belongsToMany('Book', 'book_tag');
    }
}