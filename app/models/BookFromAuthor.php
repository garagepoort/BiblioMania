<?php

/**
 * @property integer id
 * @property integer author_id
 * @property string title
 * @property string publication_year
 */
class BookFromAuthor extends Eloquent {
    protected $table = 'book_from_author';

    protected $fillable = array('title', 'publication_year', 'author_id');

    protected $with = array('books');

    public function author(){
    	return $this->belongsTo('Author');
	}

    public function books()
    {
        return $this->belongsToMany('Book', 'book_book_from_author');
    }
}