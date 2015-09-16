<?php

class AbstractIntegrationTestCase extends Illuminate\Foundation\Testing\TestCase {

	public function setUp(){
        parent::setUp();
        // $this->prepareForTests();
    }

	public function createApplication(){
		$unitTesting = true;
		$testEnvironment = 'testing';
		return require __DIR__.'/../../bootstrap/start.php';
	}

	private function prepareForTests()
    {
        Artisan::call('migrate');
    }

}
