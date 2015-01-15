<?php
class Film extends Eloquent {
    protected $table = 'film';

    protected $fillable = array('title', 'book_id');

	public function book()
    {
        return $this->belongsTo('Book');
    }
}