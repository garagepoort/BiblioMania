<?php

class GiftInfo extends Eloquent {
    protected $table = 'gift_info';

    protected $fillable = array('receipt_date', 
    	'from', 
    	'occasion',
    	'reason'
	);

	public function personal_book_info(){
    	return $this->belongsTo('PersonalBookInfo');
    }

	public function receipt_date(){
		return $this->belongsTo('Date', 'receipt_date');
	}

}