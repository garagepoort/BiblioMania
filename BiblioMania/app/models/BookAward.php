<?php


class BookAward extends Eloquent {
    protected $table = 'book_award';

    protected $fillable = array('name');

	public function books()
    {
        return $this->belongsToMany('Book', 'book_book_award');
    }
}