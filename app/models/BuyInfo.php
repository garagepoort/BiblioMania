<?php

/**
 * @property City city
 * @property double price_payed
 * @property DateTime buy_date
 */
class BuyInfo extends Eloquent {
    protected $table = 'buy_info';

    protected $fillable = array('buy_date', 'price_payed', 'reason', 'shop', 'city_id');

    protected $with = array('city', 'country');

	public function city()
    {
        return $this->belongsTo('City');
    }

    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function personal_book_info(){
    	return $this->belongsTo('PersonalBookInfo');
    }
}