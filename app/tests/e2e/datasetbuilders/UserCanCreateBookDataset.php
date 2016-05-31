<?php

namespace e2e\datasetbuilders;

use AuthorService;
use Illuminate\Support\Facades\App;

class UserCanCreateBookDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;

    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
    }

    public function run(){
        $author = new AuthorBuilder();
        $author->withName('first', 'in', 'last')
        ->withDateOfBirth(1, 1, 1992)
        ->withDateOfDeath(1, 1, 2016);
        $authorId = $this->authorService->create($author)->id;
        return ['authorId' => $authorId];
    }

    function getId()
    {
        return 'user.can.create.book';
    }
}