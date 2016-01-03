<?php

class WishlistItem extends Eloquent {
    protected $table = 'wishlist';

    protected $fillable = array(
        'book_id',
        'user_id',
	);

    protected $with = array('user', 'book');
    
	public function book(){
    	return $this->belongsTo('Book');
	}

	public function user(){
    	return $this->belongsTo('User');
	}

}