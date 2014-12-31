<?php


class Author extends Eloquent {
    protected $table = 'author';

    protected $fillable = array('name', 'firstname', 'image', 'date_of_death', 'date_of_birth', 'country_id', 'oeuvre');

    public function country(){
    	return $this->belongsTo('Country');
	}

	public function awards()
    {
        return $this->belongsToMany('AuthorAward', 'author_author_award');
    }
    
    public function books()
    {
        return $this->belongsToMany('Book', 'book_author');
    }

    public function oeuvre()
    {
        return $this->hasMany('BookFromAuthor');
    }
}