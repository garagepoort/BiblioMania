<?php

class AuthorController extends BaseController
{

    private $authorFolder = "author/";
    /** @var  AuthorService */
    private $authorService;
    /** @var  AuthorInfoParameterMapper */
    private $authorInfoParameterMapper;
    /** @var  AuthorFormValidator */
    private $authorFormValidator;
    /** @var BookFromAuthorService */
    private $bookFromAuthorService;
    /** @var DateService */
    private $dateService;
    /** @var ImageService */
    private $imageService;
    /** @var BookService */
    private $bookService;
    /** @var JsonMappingService */
    private $jsonMappingService;

    function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
        $this->authorFormValidator = App::make('AuthorFormValidator');
        $this->dateService = App::make('DateService');
        $this->imageService = App::make('ImageService');
        $this->authorInfoParameterMapper = App::make('AuthorInfoParameterMapper');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function createAuthor(){
        $author = $this->authorService->create($this->jsonMappingService->mapInputToJson(Input::get(), new CreateAuthorFromJsonAdapter()));
        return Response::json(array('success' => true, 'id' => $author->id), 200);
    }

    public function updateAuthor(){
        return $this->authorService->update($this->jsonMappingService->mapInputToJson(Input::get(), new UpdateAuthorFromJsonAdapter()))->id;
    }

    public function getAuthor($id){
        $author = $this->authorService->find($id);
        Ensure::objectNotNull("author", $author);
        $authorToJsonAdapter = new AuthorToJsonAdapter($author);
        return $authorToJsonAdapter->mapToJson();
    }

    public function getAuthorByBook($id){
        /** @var Book $book */
        $book = $this->bookService->find($id, array('authors'));

        Ensure::objectNotNull("book", $book);
        Ensure::objectNotNull("book preferred author", $book->preferredAuthor());

        $authorToJsonAdapter = new AuthorToJsonAdapter($book->preferredAuthor());
        return $authorToJsonAdapter->mapToJson();
    }

    public function getAllAuthors(){
        return array_map(function($item){
            $authorToJsonAdapter = new AuthorToJsonAdapter($item);
            return $authorToJsonAdapter->mapToJson();
        }, $this->authorService->getAllAuthors()->all());
    }

    public function getAuthors()
    {
        return View::make($this->authorFolder . 'authors')->with(array(
            'title' => 'Auteurs'
        ));
    }

    public function goToEditAuthor($id)
    {
        $author = Author::where('id', '=', $id)->with('date_of_birth', 'date_of_death')->first();
        $withArray = AuthorFormFiller::createEditAuthorArray($author);
        $withArray['title'] = 'Wijzig auteur';
        return View::make($this->authorFolder . 'editAuthor')->with($withArray);
    }

    public function getAuthorsList()
    {
        $authors = Author::with('date_of_death', 'date_of_birth')->orderBy('name', 'asc')->get();
        return View::make($this->authorFolder . 'authorsList')->with(array(
            'title' => 'Editeer auteurs',
            'authors' => $authors
        ));
    }

    public function editAuthorInList()
    {
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');

        $id = Input::get('pk');
        $name = Input::get('name');
        $value = Input::get('value');
        $logger->info('editing author with values: ' . $id . ' name: ' . $name . ' value: ' . $value);

        $author = Author::with('date_of_death', 'date_of_birth')->find($id);
        if ($author != null) {
            if ($name == 'name') {
                $author->name = $value;
            }
            if ($name == 'firstname') {
                $author->firstname = $value;
            }
            if ($name == 'infix') {
                $author->infix = $value;
            }
            if ($name == 'date_of_birth') {
                App::make('AuthorService')->deleteDateOfBirth($author);
                $author->date_of_birth_id = $this->dateService->createDateFromString($value)->id;
            }
            if ($name == 'date_of_death') {
                App::make('AuthorService')->deleteDateOfDeath($author);
                $author->date_of_death_id = $this->dateService->createDateFromString($value)->id;
            }
            $author->save();
        }
    }

    public function changeAuthorImage()
    {
        $authorId = Input::get('author_id');
        $image = $this->authorInfoParameterMapper->getImage();
        $imageSaveType = $this->authorInfoParameterMapper->getImageSaveType();

        $this->authorService->updateAuthorImage($authorId, $image, $imageSaveType);
        return Redirect::to("/getAuthor/$authorId");
    }

    public function getNextAuthors()
    {
        $query = Input::get('query');
        $operator = Input::get('operator');
        $type = Input::get('type');
        $orderBy = Input::get('orderBy');
        return $this->authorService->getFilteredAuthors($query, $operator, $type, $orderBy);
    }

    public function getOeuvreForAuthor($author_id)
    {
        return Author::find($author_id)->oeuvre;
    }

    public function deleteBookFromAuthor()
    {
        $id = Input::get('bookFromAuthorId');
        $this->bookFromAuthorService->delete($id);
    }

    public function editBookFromAuthor()
    {
        $author_id = Input::get('authorId');
        $id = Input::get('bookFromAuthorId');
        $title = Input::get('title');
        $year = Input::get('publication_year');

        $this->bookFromAuthorService->edit($id, $title, $year);
        return Response::json(Author::with('oeuvre')->find($author_id));
    }

    public function addBookFromAuthor()
    {
        $title = Input::get('title');
        $year = Input::get('publication_year');
        $author_id = Input::get('authorId');
        $this->bookFromAuthorService->save($author_id, $title, $year);

    }

    public function updateBookFromAuthorTitle()
    {
        $id = Input::get('pk');
        $value = Input::get('value');
        $this->bookFromAuthorService->updateTitle($id, $value);
    }

    public function getAuthorsWithOeuvreJson()
    {
        return Response::json(Author::with('oeuvre')->all());
    }
}