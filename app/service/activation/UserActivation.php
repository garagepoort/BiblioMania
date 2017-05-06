<?php

class UserActivation extends Eloquent
{
	protected $table = 'user_activations';

	protected $fillable = array('user_id', 'token');
}