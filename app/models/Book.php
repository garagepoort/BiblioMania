<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Eloquent {
	use SoftDeletes;

    protected $table = 'book';

    protected $fillable = array(
    	'title',
    	'subtitle',
    	'ISBN',
    	'translator',
    	'type_of_cover',
    	'coverImage',
    	'genre_id',
        'publisher_id',
    	'publisher_country_id',
    	'publication_date_id',
    	'number_of_pages',
    	'print',
    	'serie_id',
    	'publisher_serie_id',
        'first_print_info_id',
        'retail_price',
        'summary',
		'language_id',
		'currency'
    	);

	protected $dates = ['deleted_at'];

	protected $with = array('publication_date', 'first_print_info', 'language', 'personal_book_infos');

	public function mainAuthor(){
		foreach($this->authors as $author){
			if($author->pivot->preferred == true){
				return $author;
			}
		}
		return null;
	}

	public function secondaryAuthors(){
		$result = [];
		foreach($this->authors as $author){
			if($author->pivot->preferred == false){
				array_push($result, $author);
			}
		}
		return $result;
	}

    public function authors(){
    	return $this->belongsToMany('Author', 'book_author')->withPivot('preferred');
	}

    public function wishlists(){
    	return $this->hasMany('WishlistItem', 'book_id');
	}

	public function book_from_authors(){
		return $this->belongsToMany('BookFromAuthor', 'book_book_from_author');
	}

	public function tags(){
    	return $this->belongsToMany('Tag', 'book_tag');
	}

	public function genre(){
    	return $this->belongsTo('Genre');
	}

	public function publisher(){
    	return $this->belongsTo('Publisher');
	}

	public function country(){
    	return $this->belongsTo('Country', 'publisher_country_id');
	}

    public function publication_date(){
        return $this->belongsTo('Date', 'publication_date_id');
    }

	public function serie(){
    	return $this->belongsTo('Serie');
	}

    public function publisher_serie(){
        return $this->belongsTo('PublisherSerie');
    }

	public function personal_book_infos(){
    	return $this->hasMany('PersonalBookInfo', 'book_id');
	}

    public function first_print_info(){
        return $this->belongsTo('FirstPrintInfo', 'first_print_info_id');
    }

    public function awards()
    {
        return $this->belongsToMany('BookAward', 'book_book_award');
    }

    public function films()
    {
        return $this->hasMany('Film');
    }
	public function language(){
		return $this->belongsTo('Language');
	}

}