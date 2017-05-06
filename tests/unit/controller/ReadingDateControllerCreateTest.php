<?php

namespace tests\unit\controller;

use BaseReadingDateRequest;
use PermissionService;
use ReadingDateService;
use Mockery;
use TestCase;
use User;

class ReadingDateControllerCreateTest extends TestCase
{
	const USER_ID = 123;
	const DAY = 23;
	const MONTH = 12;
	const YEAR = 2017;
	const PERSONAL_BOOK_INFO_ID = 321;
	const RATING = 5;
	const REVIEW = "review";
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

	public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
		$this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'CREATE_READING_DATE')->andReturn(false);

		$response = $this->action('POST', 'ReadingDateController@createReadingDate', array(), array());

		$this->assertResponseStatus(403);
		$this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
	}

	public function test_createsCorrectly(){
		$this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'CREATE_READING_DATE')->andReturn(true);

		$postData = array(
				'date' => array('day' => self::DAY, 'month' => self::MONTH, 'year' => self::YEAR),
				'personalBookInfoId' => self::PERSONAL_BOOK_INFO_ID,
				'rating' => self::RATING,
				'review' => self::REVIEW
			);

		$this->readingDateService->shouldReceive('createReadingDate')->once()->with(self::USER_ID, Mockery::on(function(BaseReadingDateRequest $createReadingDateRequest){
			$this->assertEquals(self::DAY, $createReadingDateRequest->getDate()->getDay());
			$this->assertEquals(self::MONTH, $createReadingDateRequest->getDate()->getMonth());
			$this->assertEquals(self::YEAR, $createReadingDateRequest->getDate()->getYear());
			$this->assertEquals(self::PERSONAL_BOOK_INFO_ID, $createReadingDateRequest->getPersonalBookInfoId());
			$this->assertEquals(self::RATING, $createReadingDateRequest->getRating());
			$this->assertEquals(self::REVIEW, $createReadingDateRequest->getReview());
			return true;
		}))->andReturn(self::READING_DATE_ID);

		$response = $this->action('POST', 'ReadingDateController@createReadingDate', array(), $postData);

		$this->assertResponseOk();
		$this->assertEquals($response->getData()->id, self::READING_DATE_ID);
	}

}