<?php


class BuyInfo extends Eloquent {
    protected $table = 'buy_info';

    protected $fillable = array('buy_date', 'price_payed', 'recommended_by', 'shop', 'city_id');

	public function city()
    {
        return $this->belongsTo('City');
    }

    public function personal_book_info(){
    	return $this->belongsTo('PersonalBookInfo');
    }
}