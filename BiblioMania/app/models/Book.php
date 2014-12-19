<?php


class Book extends Eloquent {
    protected $table = 'book';

    protected $fillable = array(
    	'title', 
    	'subtitle', 
    	'author_id', 
    	'ISBN', 
    	'type_of_cover', 
    	'coverImage',
    	'genre_id',
    	'publisher_id',
    	'publication_date',
    	'country_id',
    	'number_of_pages',
    	'print',
    	'serie_id',
    	'publisher_serie_id',
        'user_id'
    	);

    public function author(){
    	return $this->belongsTo('Author');
	}

	public function genre(){
    	return $this->belongsTo('Genre');
	}

	public function publisher(){
    	return $this->belongsTo('Publisher');
	}

	public function country(){
    	return $this->belongsTo('Country');
	}
    
	public function serie(){
    	return $this->belongsTo('Serie');
	}

    public function publisher_serie(){
        return $this->belongsTo('PublisherSerie');
    }

	public function personal_book_info(){
    	return $this->hasOne('PersonalBookInfo');
	}
    
	public function awards()
    {
        return $this->belongsToMany('BookAward', 'book_book_award');
    }

    public function films()
    {
        return $this->hasMany('Film');
    }

}