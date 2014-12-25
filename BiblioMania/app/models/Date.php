<?php

class Date extends Eloquent{
 	protected $table = 'date';
 	public $timestamps = false;
 	
    protected $fillable = array('day', 'month', 'year');


}