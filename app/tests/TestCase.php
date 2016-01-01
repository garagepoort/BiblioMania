<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	public function tearDown()
	{
	  Mockery::close();
	}

	public function setUp()
	{
		parent::setUp(); // Don't forget this!

		$this->prepareForTests();
	}
	
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	private function prepareForTests()
	{
		Mail::pretend(true);
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
