<?php

namespace tests\unit\controller;

use CreateFirstPrintInfoRequest;
use FirstPrintInfo;
use FirstPrintInfoService;
use Mockery;
use PermissionService;
use TestCase;
use User;

class FirstPrintInfoControllerCreateTest extends TestCase
{
    const USER_ID = 123;
    const TITLE = 'title';
    const SUBTITLE = 'subtitle';
    const ISBN = '2301203421321';
    const PUBLISHER = 'publisher';
    const PUBLICATION_DATE_DAY = 31;
    const PUBLICATION_DATE_MONTH = 12;
    const PUBLICATION_DATE_YEAR = 2015;
    const COUNTRY = 'country';
    const LANGUAGE = 'language';
    const BOOK_ID_TO_LINK = 432;
    const FIRST_PRINT_INFO_ID = 2324;

    /** @var FirstPrintInfoService $firstPrintInfoService */
    private $firstPrintInfoService;

    /** @var FirstPrintInfo $firstPrintInfo */
    private $firstPrintInfo;
    /** @var PermissionService $permissionService */
    private $permissionService;


    public function setUp(){
        parent::setUp();

        $this->firstPrintInfoService = $this->mock('FirstPrintInfoService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'CREATE_FIRST_PRINT')->andReturn(false);

        $response = $this->action('POST', 'FirstPrintInfoController@createFirstPrintInfo', array(), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_callsJsonMappingAndService(){
        $this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'CREATE_FIRST_PRINT')->andReturn(true);
        $this->firstPrintInfo = $this->mockEloquent('FirstPrintInfo');
        $this->firstPrintInfo->shouldReceive('getAttribute')->once()->with('id')->andReturn(self::FIRST_PRINT_INFO_ID);

        $postData = array(
            'title' => self::TITLE,
            'subtitle' => self::SUBTITLE,
            'isbn' => self::ISBN,
            'publisher' => self::PUBLISHER,
            'publicationDate' => array('day'=> self::PUBLICATION_DATE_DAY, 'month'=> self::PUBLICATION_DATE_MONTH, 'year'=> self::PUBLICATION_DATE_YEAR),
            'country' => self::COUNTRY,
            'language' => self::LANGUAGE,
            'bookIdToLink' => self::BOOK_ID_TO_LINK
        );

        $this->firstPrintInfoService->shouldReceive('createFirstPrintInfo')->once()->with(self::USER_ID, Mockery::on(function(CreateFirstPrintInfoRequest $createFirstPrintInfoRequest){
            $this->assertEquals(self::TITLE, $createFirstPrintInfoRequest->getTitle());
            $this->assertEquals(self::ISBN, $createFirstPrintInfoRequest->getIsbn());
            $this->assertEquals(self::SUBTITLE, $createFirstPrintInfoRequest->getSubtitle());
            $this->assertEquals(self::PUBLISHER, $createFirstPrintInfoRequest->getPublisher());
            $this->assertEquals(self::COUNTRY, $createFirstPrintInfoRequest->getCountry());
            $this->assertEquals(self::LANGUAGE, $createFirstPrintInfoRequest->getLanguage());
            $this->assertEquals(self::BOOK_ID_TO_LINK, $createFirstPrintInfoRequest->getBookIdToLink());

            $publicationDate = $createFirstPrintInfoRequest->getPublicationDate();
            $this->assertEquals(self::PUBLICATION_DATE_DAY, $publicationDate->getDay());
            $this->assertEquals(self::PUBLICATION_DATE_MONTH, $publicationDate->getMonth());
            $this->assertEquals(self::PUBLICATION_DATE_YEAR, $publicationDate->getYear());

            return true;
        }))->andReturn($this->firstPrintInfo);

        $this->action('POST', 'FirstPrintInfoController@createFirstPrintInfo', array(), $postData);

        $this->assertResponseOk();
    }

}