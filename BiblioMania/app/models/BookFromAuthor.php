<?php


class BookFromAuthor extends Eloquent {
    protected $table = 'book_from_author';

    protected $fillable = array('title', 'publication_year', 'author_id');

    protected $with = array('books');

    public function author(){
    	return $this->belongsTo('Author');
	}
    
    public function books()
    {
        return $this->hasMany('Book');
    }

}