<?php
class PersonalBookInfo extends Eloquent {
    protected $table = 'personal_book_info';

    protected $fillable = array(
    	'owned',
    	'rating',
    	'retail_price',
        'review',
        'book_id',
        'reason_not_owned'
	);
    
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

}