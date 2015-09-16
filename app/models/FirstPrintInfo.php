<?php
class FirstPrintInfo extends Eloquent {
    protected $table = 'first_print_info';

    protected $fillable = array('title', 
        'subtitle',
    	'publisher_id', 
    	'publication_date_id', 
    	'country_id', 
    	'language_id', 
    	'ISBN',
    	'cover_image'
	);

    protected $with = array('publication_date', 'country', 'publisher', 'language');

	public function publisher(){
    	return $this->belongsTo('Publisher');
	}

    public function publication_date(){
        return $this->belongsTo('Date', 'publication_date_id');
    }

	public function country(){
    	return $this->belongsTo('Country');
	}

	public function language(){
    	return $this->belongsTo('Language');
	}
}