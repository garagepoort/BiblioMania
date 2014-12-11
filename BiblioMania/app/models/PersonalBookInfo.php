<?php
class PersonalBookInfo extends Eloquent {
    protected $table = 'personal_book_info';

    protected $fillable = array(
    	'owned',
    	'rating',
    	'retail_price'
	);
	public function buy_info(){
    	return $this->hasOne('BuyInfo');
	}

	public function gift_info(){
    	return $this->hasOne('GiftInfo');
	}

    public function reading_dates()
    {
        return $this->belongsToMany('ReadingDate', 'book_reading_date');
    }

    public function films()
    {
        return $this->hasMany('Film');
    }

}