<?php

namespace tests\unit\controller;

use BaseBookRequest;
use BookService;
use Mockery;
use PermissionService;
use TestCase;
use User;

class BookControllerCreateTest extends TestCase
{
    const TITLE = 'title';
    const SUBTITLE = 'subtitle';
    const GENRE = 'genre';
    const PUBLISHER = 'publisher';
    const COUNTRY = 'country';
    const LANGUAGE = 'language';
    const PREFERRED_AUTHOR_ID = 213;
    const PUBLICATION_DATE_DAY = 31;
    const PUBLICATION_DATE_MONTH = 12;
    const CURRENCY = 'USD';
    const RETAIL_PRICE = 12.23;
    const PUBLICATION_DATE_YEAR = 2015;
    const SUMMARY = 'my summary';
    const TRANSLATOR = 'translator';
    const _PRINT = 12;
    const PAGES = 1231;
    const IMAGE_URL = 'imageUrl';
    const ISBN = '2301203421321';
    const SERIE = 'serie';
    const PUBLISHER_SERIE = 'publisherSerie';
    const TAG_1 = 'tag1';
    const TAG_2 = 'tag2';
    const TAG_3 = 'tag3';
    const USER_ID = 123;

    /** @var  BookService */
    private $bookService;
    /** @var  PermissionService */
    private $permissionService;

    public function setUp()
    {
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->permissionService = $this->mock('PermissionService');
        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'CREATE_BOOK')->andReturn(false);

        $response = $this->action('POST', 'BookController@createBook', array(), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }


    public function test_shouldCallJsonMappingAndServiceWhenUserHasCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'CREATE_BOOK')->andReturn(true);

        $postData = array(
            'title' => self::TITLE,
            'isbn' => self::ISBN,
            'subtitle' => self::SUBTITLE,
            'genre' => self::GENRE,
            'publisher' => self::PUBLISHER,
            'country' => self::COUNTRY,
            'language' => self::LANGUAGE,
            'translator' => self::TRANSLATOR,
            'print' => self::_PRINT,
            'summary' => self::SUMMARY,
            'pages' => self::PAGES,
            'imagUrl' => self::IMAGE_URL,
            'serie' => self::SERIE,
            'publisherSerie' => self::PUBLISHER_SERIE,
            'retailPrice'=> array('amount'=>self::RETAIL_PRICE, 'currency' => self::CURRENCY),
            'preferredAuthorId' => self::PREFERRED_AUTHOR_ID,
            'publicationDate' => array('day'=> self::PUBLICATION_DATE_DAY, 'month'=> self::PUBLICATION_DATE_MONTH, 'year'=> self::PUBLICATION_DATE_YEAR),
            'tags' => array(
                array('text'=> self::TAG_1),
                array('text'=> self::TAG_2),
                array('text'=> self::TAG_3)
            )
        );

        $this->bookService->shouldReceive('create')->once()->with(self::USER_ID, Mockery::on(function(BaseBookRequest $baseBookRequest){
            $this->assertEquals(self::TITLE, $baseBookRequest->getTitle());
            $this->assertEquals(self::ISBN, $baseBookRequest->getIsbn());
            $this->assertEquals(self::SUBTITLE, $baseBookRequest->getSubtitle());
            $this->assertEquals(self::SUMMARY, $baseBookRequest->getSummary());
            $this->assertEquals(self::PREFERRED_AUTHOR_ID, $baseBookRequest->getPreferredAuthorId());
            $this->assertEquals(self::PUBLISHER, $baseBookRequest->getPublisher());
            $this->assertEquals(self::COUNTRY, $baseBookRequest->getCountry());
            $this->assertEquals(self::LANGUAGE, $baseBookRequest->getLanguage());
            $this->assertEquals(self::GENRE, $baseBookRequest->getGenre());
            $this->assertEquals(self::TRANSLATOR, $baseBookRequest->getTranslator());
            $this->assertEquals(self::_PRINT, $baseBookRequest->getPrint());
            $this->assertEquals(self::PAGES, $baseBookRequest->getPages());
            $this->assertEquals(self::SERIE, $baseBookRequest->getSerie());
            $this->assertEquals(self::CURRENCY, $baseBookRequest->getRetailPrice()->getCurrency());
            $this->assertEquals(self::RETAIL_PRICE, $baseBookRequest->getRetailPrice()->getAmount());
            $this->assertEquals(self::PUBLISHER_SERIE, $baseBookRequest->getPublisherSerie());

            $publicationDate = $baseBookRequest->getPublicationDate();
            $this->assertEquals(self::PUBLICATION_DATE_DAY, $publicationDate->getDay());
            $this->assertEquals(self::PUBLICATION_DATE_MONTH, $publicationDate->getMonth());
            $this->assertEquals(self::PUBLICATION_DATE_YEAR, $publicationDate->getYear());

            $tags = $baseBookRequest->getTags();
            $this->assertEquals(self::TAG_1, $tags[0]->getText());
            $this->assertEquals(self::TAG_2, $tags[1]->getText());
            $this->assertEquals(self::TAG_3, $tags[2]->getText());

            return true;
        }));

        $response = $this->action('POST', 'BookController@createBook', array(), $postData);

        $this->assertResponseOk();
    }
}