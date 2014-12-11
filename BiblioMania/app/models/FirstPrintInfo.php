<?php


class FirstPrintInfo extends Eloquent {
    protected $table = 'first_print_info';

    protected $fillable = array('title', 
        'subtitle',
    	'publisher_id', 
    	'publication_date', 
    	'country_id', 
    	'language_id', 
    	'ISBN', 
    	'cover_image'
	);

	public function publisher(){
    	return $this->belongsTo('Publisher');
	}

	public function country(){
    	return $this->belongsTo('Country');
	}

	public function language(){
    	return $this->belongsTo('Language');
	}

}