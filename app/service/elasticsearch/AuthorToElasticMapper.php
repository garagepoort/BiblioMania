<?php

class AuthorToElasticMapper
{

	public function map(Author $author){
		return [
			'id' => intval($author->id),
			'firstname' => $author->firstname,
			'lastname' => $author->name
		];
	}

	public function mapAuthors($authors)
	{
		return array_map(function($author){
			$this->map($author);
		}, $authors);
	}
}