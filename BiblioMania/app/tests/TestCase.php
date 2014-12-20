<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	public function tearDown()
	{
	  Mockery::close();
	}
	
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	public function mock($class)
	{
	  $mock = Mockery::mock($class);
	 
	  $this->app->instance($class, $mock);
	 
	  return $mock;
	}
}
