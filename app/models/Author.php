<?php

/**
 * Class Author
 *
 * @property string name
 */
class Author extends Eloquent {
    protected $table = 'author';

    protected $fillable = array('name', 'firstname', 'image', 'date_of_death_id', 'date_of_birth_id', 'country_id', 'oeuvre', 'gender');

    protected $with = array('date_of_birth', 'date_of_death');

    public function country(){
    	return $this->belongsTo('Country');
	}

	public function awards()
    {
        return $this->belongsToMany('AuthorAward', 'author_author_award');
    }
    
    public function books()
    {
        return $this->belongsToMany('Book', 'book_author')->withPivot('preferred');
    }

    public function oeuvre()
    {
        return $this->hasMany('BookFromAuthor')->orderBy('publication_year');
    }

    public function date_of_birth(){
        return $this->belongsTo('Date', 'date_of_birth_id');
    }

    public function date_of_death(){
        return $this->belongsTo('Date', 'date_of_death_id');
    }
}