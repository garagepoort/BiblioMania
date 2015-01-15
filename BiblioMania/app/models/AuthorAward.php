<?php
class AuthorAward extends Eloquent {
    protected $table = 'author_award';

    protected $fillable = array('name');

	public function authors()
    {
        return $this->belongsToMany('Author', 'author_author_award');
    }
}