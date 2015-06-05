<?php

class GoogleApiToken extends Eloquent {
    protected $table = 'google_api_tokens';

    protected $fillable = array('username', 'access_token','refresh_token');

}