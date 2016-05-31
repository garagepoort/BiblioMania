<?php

/**
 * @property integer id
 * @property integer day
 * @property integer month
 * @property integer year
 */
class Date extends Eloquent{
 	protected $table = 'date';
 	public $timestamps = false;
 	
    protected $fillable = array('day', 'month', 'year');


}