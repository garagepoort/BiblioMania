<?php
class FilterHistory extends Eloquent {
    protected $table = 'filter_history';
    public $timestamps = false;

    protected $fillable = array('filter_id', 'times_used');

}