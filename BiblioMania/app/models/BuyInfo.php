<?php


class BuyInfo extends Eloquent {
    protected $table = 'buy_info';

    protected $fillable = array('buy_date', 'price_payed', 'reason', 'shop', 'city_id');

	public function city()
    {
        return $this->belongsTo('City');
    }
}