<?php

class BuyInfo extends Eloquent {
    protected $table = 'buy_info';

    protected $fillable = array('buy_date', 'price_payed', 'reason', 'shop', 'city_id');

    protected $with = array('city');

	public function city()
    {
        return $this->belongsTo('City');
    }

    public function personal_book_info(){
    	return $this->belongsTo('PersonalBookInfo');
    }
}