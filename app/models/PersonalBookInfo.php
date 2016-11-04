<?php

/**
 * @property integer id
 * @property string reason_not_owned
 * @property Book book
 * @property integer book_id
 * @property integer user_id
 * @property boolean owned
 * @property \Illuminate\Database\Eloquent\Collection reading_dates
 */
class PersonalBookInfo extends Eloquent {
    protected $table = 'personal_book_info';

    protected $fillable = array(
        'owned',
    	'read',
    	'retail_price',
        'book_id',
        'user_id',
        'reason_not_owned'
	);

    protected $with = array('gift_info', 'buy_info', 'reading_dates');
    
	public function buy_info(){
    	return $this->hasOne('BuyInfo');
	}

	public function gift_info(){
    	return $this->hasOne('GiftInfo');
	}

	public function book(){
    	return $this->belongsTo('Book');
	}

    public function reading_dates()
    {
        return $this->hasMany('ReadingDate', 'personal_book_info_id');
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