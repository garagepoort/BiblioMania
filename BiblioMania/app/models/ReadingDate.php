<?php


class ReadingDate extends Eloquent {
    protected $table = 'reading_date';

    protected $fillable = array('date');

	public function books()
    {
        return $this->belongsToMany('Book', 'book_reading_date');
    }
}