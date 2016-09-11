<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookService;
use Illuminate\Support\Facades\App;
use OeuvreService;
use UserService;

class UserCanLinkAndUnlinkOeuvreItemToBookDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;
    /** @var  BookService $bookService */
    private $bookService;
    /** @var UserService $userService */
    private $userService;
    /** @var OeuvreService $oeuvreService */
    private $oeuvreService;

    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookService = App::make('BookService');
        $this->userService = App::make('UserService');
        $this->oeuvreService = App::make('OeuvreService');
    }

    public function run()
    {
        $userId = $this->createUser();
        $authorId = $this->createAuthor('author1_first', 'author1_last')->id;
        $bookId = $this->createBook($userId, $authorId);

        return ['bookId' => $bookId, 'authorId' => $authorId, 'oeuvreItemId' => $this->createOeuvreItem($authorId)];
    }

    function getId()
    {
        return 'user.can.link.and.unlink.oeuvre.item.to.book';
    }

    function createUser(){
        $user = $this->userService->createUser('testUser', 'test@test.be', 'test');
        return $user->id;
    }

    function createOeuvreItem($authorId){
        $builder = new OeuvreItemBuilder();
        $builder->withAuthorId($authorId)
            ->withPublicationYear(1991)
            ->withTitle('oeuvre title');
        return $this->oeuvreService->createOeuvreItem($builder)->id;
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