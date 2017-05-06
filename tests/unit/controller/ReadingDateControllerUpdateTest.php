<?php

namespace tests\unit\controller;

use PermissionService;
use ReadingDateService;
use Mockery;
use TestCase;
use UpdateReadingDateRequest;
use User;

class ReadingDateControllerUpdateTest extends TestCase
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
		$this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'UPDATE_READING_DATE')->andReturn(false);

		$response = $this->action('PUT', 'ReadingDateController@updateReadingDate', array(), array());

		$this->assertResponseStatus(403);
		$this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
	}

	public function test_createsCorrectly(){
		$this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'UPDATE_READING_DATE')->andReturn(true);

		$postData = array(
				'id' => self::READING_DATE_ID,
				'date' => array('day' => self::DAY, 'month' => self::MONTH, 'year' => self::YEAR),
				'personalBookInfoId' => self::PERSONAL_BOOK_INFO_ID,
				'rating' => self::RATING,
				'review' => self::REVIEW
			);

		$this->readingDateService->shouldReceive('updateReadingDate')->once()->with(self::USER_ID, Mockery::on(function(UpdateReadingDateRequest $updateReadingDateRequest){
			$this->assertEquals(self::READING_DATE_ID, $updateReadingDateRequest->getId());
			$this->assertEquals(self::DAY, $updateReadingDateRequest->getDate()->getDay());
			$this->assertEquals(self::MONTH, $updateReadingDateRequest->getDate()->getMonth());
			$this->assertEquals(self::YEAR, $updateReadingDateRequest->getDate()->getYear());
			$this->assertEquals(self::PERSONAL_BOOK_INFO_ID, $updateReadingDateRequest->getPersonalBookInfoId());
			$this->assertEquals(self::RATING, $updateReadingDateRequest->getRating());
			$this->assertEquals(self::REVIEW, $updateReadingDateRequest->getReview());
			return true;
		}))->andReturn(self::READING_DATE_ID);

		$response = $this->action('PUT', 'ReadingDateController@updateReadingDate', array(), $postData);

		$this->assertResponseOk();
		$this->assertEquals($response->getData()->id, self::READING_DATE_ID);
	}

}