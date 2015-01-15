<?php

class ReadingDate extends Eloquent {
    protected $table = 'reading_date';

    protected $fillable = array('date');
    public $timestamps = false;

	public function personal_book_infos()
    {
        return $this->belongsToMany('PersonalBookInfo', 'personal_book_info_reading_date');
    }
}