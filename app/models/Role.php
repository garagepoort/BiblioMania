<?php
class Role extends Eloquent {
    protected $table = 'roles';

    protected $fillable = array('name');

    public $timestamps = false;

}