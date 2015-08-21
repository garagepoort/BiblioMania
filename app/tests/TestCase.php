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
		Artisan::call('migrate');
		Mail::pretend(true);
	}

	public function mock($class)
	{
	  $mock = Mockery::mock($class)->shouldIgnoreMissing();
	 
	  $this->app->instance($class, $mock);
	 
	  return $mock;
	}

	public function mockEloquent($class)
	{
	  return Mockery::mock('Eloquent', $class)->shouldIgnoreMissing();
	}

	public function createFakeBook(){
		$pivot = new stdClass();
		$pivot->preferred = true;

		$author = new Author();
		$author->name = "authorName";
		$author->firstname = "authorFirstName";
		$author->pivot = $pivot;

		$publisher = new Publisher();
		$publisher->name = "publisher name";

		$book = new Book();
		$book->id = "book id";
		$book->publisher = $publisher;

		$book->authors = array($author);
		return $book;
	}
}
