<?php

namespace e2e\datasetbuilders;

use AuthorService;
use UserService;
use Illuminate\Support\Facades\App;

class UserCanCreateBookDataSet implements DataSet
{

    /** @var  UserService $userService */
    private $userService;
    /** @var  AuthorService $authorService */
    private $authorService;

    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->userService = App::make('UserService');
    }

    public function run(){
        $userId = $this->createUser();
        $author = new AuthorBuilder();
        $author->withName('first', 'in', 'last')
        ->withDateOfBirth(1, 1, 1992)
        ->withDateOfDeath(1, 1, 2016);
        $authorId = $this->authorService->create($author)->id;
        return ['authorId' => $authorId];
    }

    function createUser(){
        $user = $this->userService->createActiveUser(CreateUserRequestBuilder::buildDefault());
        return $user->id;
    }

    function getId()
    {
        return 'user.can.create.book';
    }
}