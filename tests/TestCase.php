<?php

use Illuminate\Support\Facades\Mail;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function setUp()
    {
        parent::setUp(); // Don't forget this!

        $this->prepareForTests();
    }

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    private function prepareForTests()
    {
    }

    /**
     * @param $class
     * @return \Mockery\Mock
     */
    public function mock($class)
    {
        $mock = Mockery::mock($class)->shouldIgnoreMissing();

        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * @param $class
     * @return \Mockery\Mock
     */
    public function mockEloquent($class)
    {
        return Mockery::mock('Eloquent', $class)->shouldIgnoreMissing();
    }

    /**
     * @return \Mockery\Mock
     */
    public function mockEloquentCollection()
    {
        return $this->mockEloquent('Illuminate\Database\Eloquent\Collection');
    }

    public function createFakeBook(){
        $pivot = new stdClass();
        $pivot->preferred = true;

        $author = new Author();
        $author->id = 123;
        $author->name = "authorName";
        $author->firstname = "authorFirstName";
        $author->pivot = $pivot;
        $author->oeuvre = array();

        $publisher = new Publisher();
        $publisher->name = "publisher name";

        $book = new Book();
        $book->id = "book id";
        $book->publisher = $publisher;

        $book->authors = array($author);
        $author->books = array($book);
        return $book;
    }

    public function createFakeBookFromAuthor(Author $author){
        $bookFromAuthor = new BookFromAuthor();
        $bookFromAuthor->author = $author;
        return $bookFromAuthor;
    }
}
