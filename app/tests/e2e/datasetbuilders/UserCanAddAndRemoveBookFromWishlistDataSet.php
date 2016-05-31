<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookService;
use Illuminate\Support\Facades\App;
use UserService;

class UserCanAddAndRemoveBookFromWishlistDataSet implements DataSet
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
        $bookId = $this->createBook($userId, $author1->id);

        return ['bookId' => $bookId];
    }

    function getId()
    {
        return 'user.can.add.and.remove.book.from.wishlist';
    }

    function createUser(){
        $user = $this->userService->createUser('testUser', 'test@test.be', 'test');
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