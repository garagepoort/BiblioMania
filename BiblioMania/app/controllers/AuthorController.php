<?php

class AuthorController extends BaseController {

	public function getAuthors()
	{
		return View::make('authors')->with(array(
            'title' => 'Auteurs'
        ));
	}

	public function getNextAuthors(){
		return Author::orderBy('name')->orderBy('firstname')->paginate(60)->toJson();
	}

	public function getAuthor($author_id){
		$author = Author::with('oeuvre')->find($author_id);
		return View::make('author')->with(array(
			'title' => 'Auteur',
			'author' => $author,
            'author_json' => json_encode($author)
		));
	}

	public function getOeuvreForAuthor($author_id){
		return Author::find($author_id)->oeuvre;
	}

	public function deleteBookFromAuthor(){
		$id = Input::get('bookFromAuthorId');
		App::make('BookFromAuthorService')->delete($id);
	}

	public function editBookFromAuthor(){
		$author_id = Input::get('authorId');
		$id = Input::get('bookFromAuthorId');
		$title = Input::get('title');
		$year = Input::get('publication_year');
		App::make('BookFromAuthorService')->edit($id, $title, $year);
		return Response::json(Author::with('oeuvre')->find($author_id));
	}

	public function getAuthorsWithOeuvreJson(){
		return Response::json(Author::with('oeuvre')->all());
	}
}