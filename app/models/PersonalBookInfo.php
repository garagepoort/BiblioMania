<?php

class PersonalBookInfo extends Eloquent {
    protected $table = 'personal_book_info';

    protected $fillable = array(
        'owned',
    	'read',
    	'rating',
    	'retail_price',
        'review',
        'book_id',
        'reason_not_owned'
	);

    protected $with = array('gift_info', 'buy_info', 'reading_dates');
    
	public function buy_info(){
    	return $this->hasOne('BuyInfo');
	}

	public function gift_info(){
    	return $this->hasOne('GiftInfo');
	}

    public function reading_dates()
    {
        return $this->belongsToMany('ReadingDate', 'personal_book_info_reading_date');
    }

    public function set_owned($owned){
        $this->attributes['owned'] = $owned?1:0;
    }

    public function get_owned(){
        $owned = $this->attributes['owned'];
        if($owned == 0){
            return false;
        }else{
            return true;
        }
    }
    public function set_read($read){
        $this->attributes['read'] = $read?1:0;
    }

    public function get_read(){
        $read = $this->attributes['read'];
    if($read == 0){
            return false;
        }else{
            return true;
        }
    }

}