<?php

/**
 * @property string language
 */
class Language extends Eloquent {
    protected $table = 'language';

    protected $fillable = array('language');

    public $timestamps = false;

}