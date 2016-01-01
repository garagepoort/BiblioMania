<?php

class ReadingDate extends Eloquent {
    public $timestamps = false;

    protected $table = 'reading_date';

    protected $fillable = array('date', 'review', 'rating', 'personal_book_info_id');

	public function personal_book_info()
    {
        return $this->belongsTo('PersonalBookInfo', 'personal_book_info_id');
    }

}