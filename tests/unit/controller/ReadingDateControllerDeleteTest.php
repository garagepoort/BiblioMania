<?php

namespace tests\unit\controller;

use PermissionService;
use ReadingDateService;
use Mockery;
use TestCase;
use User;

class ReadingDateControllerDeleteTest extends TestCase
{
	const USER_ID = 123;
	const READING_DATE_ID = 999;

	/** @var ReadingDateService $readingDateService */
	private $readingDateService;
	/** @var PermissionService $permissionService */
	private $permissionService;

	public function setUp(){
		parent::setUp();

		$this->permissionService = $this->mock('PermissionService');
		$this->readingDateService = $this->mock('ReadingDateService');

		$user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
		$this->be($user);
	}

	public function test_shouldFailIfUserDoesNotHaveCorrectPermission(){
		$this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'DELETE_READING_DATE')->andReturn(false);

		$response = $this->action('DELETE', 'ReadingDateController@deleteReadingDate', array('id' => self::READING_DATE_ID));

		$this->assertResponseStatus(403);
		$this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
	}

	public function test_deletesCorrectly(){
		$this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'DELETE_READING_DATE')->andReturn(true);
		$this->readingDateService->shouldReceive('deleteReadingDate')->once()->with(self::USER_ID, self::READING_DATE_ID);

		$this->action('DELETE', 'ReadingDateController@deleteReadingDate', array('id' => self::READING_DATE_ID));

		$this->assertResponseOk();
	}

}