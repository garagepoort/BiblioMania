<?php

class AuthorController extends BaseController {

	private $authorFolder = "author/";
	/** @var  AuthorService */
	private $authorService;
	/** @var BookFromAuthorService */
	private $bookFromAuthorService;

	function __construct()
	{
		$this->authorService = App::make('AuthorService');
		$this->bookFromAuthorService = App::make('BookFromAuthorService');
	}


	public function getAuthors()
	{
		return View::make('authors')->with(array(
            'title' => 'Auteurs'
        ));
	}

	public function getAuthorsList(){
		$authors = Author::with('date_of_death', 'date_of_birth')->orderBy('name', 'asc')->get();
		return View::make($this->authorFolder . 'authorsList')->with(array(
			'title' => 'Editeer auteurs',
			'authors' => $authors
		));
	}

	public function editAuthor(){
		$dateService = App::make('DateService');
		$logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');

		$id = Input::get('pk');
		$name = Input::get('name');
		$value = Input::get('value');
		$logger->info('editing author with values: ' . $id . ' name: ' . $name . ' value: ' . $value);



		$author = Author::with('date_of_death', 'date_of_birth')->find($id);
		if($author != null){
			if($name == 'name'){
				$author->name = $value;
			}
			if($name == 'firstname'){
				$author->firstname = $value;
			}
			if($name == 'infix'){
				$author->infix = $value;
			}
			if($name == 'date_of_birth'){
				App::make('AuthorService')->deleteDateOfBirth($author);
				$author->date_of_birth_id = $dateService->createDateFromString($value)->id;
			}
			if($name == 'date_of_death'){
				App::make('AuthorService')->deleteDateOfDeath($author);
				$author->date_of_death_id = $dateService->createDateFromString($value)->id;
			}
			$author->save();
		}
	}

	public function getNextAuthors(){
		$query = Input::get('query');
		$operator = Input::get('operator');
		$type = Input::get('type');
		$orderBy = Input::get('orderBy');
		return $this->authorService->getFilteredAuthors($query, $operator, $type, $orderBy);
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
		$this->bookFromAuthorService->delete($id);
	}

	public function editBookFromAuthor(){
		$author_id = Input::get('authorId');
		$id = Input::get('bookFromAuthorId');
		$title = Input::get('title');
		$year = Input::get('publication_year');
		try {
			$this->bookFromAuthorService->edit($id, $title, $year);
			return Response::json(Author::with('oeuvre')->find($author_id));
		}catch (ServiceException $e){
			return ResponseCreator::createExceptionResponse($e);
		}
	}

	public function addBookFromAuthor(){
		$title = Input::get('title');
		$year = Input::get('publication_year');
		$author_id = Input::get('authorId');
		try {
			$this->bookFromAuthorService->save($author_id, $title, $year);
		}catch (ServiceException $e){
			return ResponseCreator::createExceptionResponse($e);
		}

	}

	public function updateBookFromAuthorTitle(){
		$id = Input::get('pk');
		$value = Input::get('value');
		try {
			$this->bookFromAuthorService->updateTitle($id, $value);
		}catch (ServiceException $e){
			return ResponseCreator::createExceptionResponse($e);
		}
	}

	public function getAuthorsWithOeuvreJson(){
		return Response::json(Author::with('oeuvre')->all());
	}
}