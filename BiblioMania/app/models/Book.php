<?php


class Book extends Eloquent {
    protected $table = 'book';

    protected $fillable = array(
    	'title', 
    	'subtitle', 
    	'author_id', 
    	'ISBN', 
    	'type_of_cover', 
    	'cover_image',
    	'genre_id',
    	'publisher_id',
    	'publication_date',
    	'country_id',
    	'language_id',
    	'number_of_pages',
    	'number_of_prints',
    	'serie_id',
    	'publisher_serie_id',
    	'read',
    	'owned',
    	'buy_info_id',
    	'gift_info_id',
    	'rating',
    	'retail_price'
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

	public function language(){
    	return $this->belongsTo('Language');
	}

	public function serie(){
    	return $this->belongsTo('Serie');
	}

	public function publisher_serie(){
    	return $this->belongsTo('PublisherSerie');
	}

	public function buy_info(){
    	return $this->belongsTo('BuyInfo');
	}

	public function gift_info(){
    	return $this->belongsTo('GiftInfo');
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