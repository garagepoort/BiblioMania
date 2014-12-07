<?php


class GiftInfo extends Eloquent {
    protected $table = 'gift_info';

    protected $fillable = array('receipt_date', 
    	'from', 
    	'occasion'
	);

}