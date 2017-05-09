<?php

namespace e2e\datasetbuilders;

use AuthorService;
use AuthorToJsonAdapter;
use BookService;
use Illuminate\Support\Facades\App;
use UserService;

class UserCanLinkAndUnlinkAuthorToBookDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;
    /** @var  BookService $bookService */
    private $bookService;
    /** @var UserService $userService */
    private $userService;

    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookService = App::make('BookService');
        $this->userService = App::make('UserService');
    }

    public function run()
    {
        $userId = $this->createUser();
        $author1 = $this->createAuthor('author1_first', 'author1_last');
        $author2 = $this->createAuthor('author2_first', 'author2_last');
        $bookId = $this->createBook($userId, $author1->id);

        $author1Adapter = new AuthorToJsonAdapter($author1);
        $author2Adapter = new AuthorToJsonAdapter($author2);

        return ['preferredAuthor' => $author1Adapter->mapToJson(), 'bookId' => $bookId, 'authorToLink' => $author2Adapter->mapToJson()];
    }

    function getId()
    {
        return 'user.can.link.and.unlink.author.to.book';
    }

    function createUser(){
        $user = $this->userService->createActiveUser(CreateUserRequestBuilder::buildDefault());
        return $user->id;
    }

    function createAuthor($firstname, $lastname)
    {
        $author = AuthorBuilder::buildDefault();
        $author->withName($firstname, 'infix', $lastname);
        return $this->authorService->create($author);
    }

    function createBook($userId, $authorId)
    {
        $book = BookBuilder::buildDefault($authorId);
        return $this->bookService->create($userId, $book)->id;
    }
}