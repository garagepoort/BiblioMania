<?php

class AuthorController extends BaseController {

	public function getAuthors()
	{
        $authors = Author::all()->paginate(25);
		return View::make('authors')->with(array(
            'title' => 'Auteurs',
            'authors' => $authors,
            'authors_json' => $authors->toJson()
        ));
	}

	public function getAuthor($author_id){
		return View::make('author')->with(array(
			'title' => 'Auteur',
			'author' => Author::find($author_id)
		));
	}
}