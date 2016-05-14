<?php

class FirstPrintInfoUpdateTest extends TestCase
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
    const FIRST_PRINT_INFO_ID = 2324;

    /** @var FirstPrintInfoService $firstPrintInfoService */
    private $firstPrintInfoService;

    /** @var FirstPrintInfo $firstPrintInfo */
    private $firstPrintInfo;

    public function setUp(){
        parent::setUp();

        $this->firstPrintInfoService = $this->mock('FirstPrintInfoService');
        $this->firstPrintInfo = $this->mockEloquent('FirstPrintInfo');
        $this->firstPrintInfo->shouldReceive('getAttribute')->once()->with('id')->andReturn(self::FIRST_PRINT_INFO_ID);

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_callsJsonMappingAndService(){
        $postData = array(
            'title' => self::TITLE,
            'subtitle' => self::SUBTITLE,
            'isbn' => self::ISBN,
            'publisher' => self::PUBLISHER,
            'publicationDate' => array('day'=> self::PUBLICATION_DATE_DAY, 'month'=> self::PUBLICATION_DATE_MONTH, 'year'=> self::PUBLICATION_DATE_YEAR),
            'country' => self::COUNTRY,
            'language' => self::LANGUAGE,
            'id' => self::FIRST_PRINT_INFO_ID
        );

        $this->firstPrintInfoService->shouldReceive('updateFirstPrintInfo')->once()->with(self::USER_ID, Mockery::on(function(UpdateFirstPrintInfoRequest $updateFirstPrintInfoRequest){
            $this->assertEquals(self::FIRST_PRINT_INFO_ID, $updateFirstPrintInfoRequest->getId());
            $this->assertEquals(self::TITLE, $updateFirstPrintInfoRequest->getTitle());
            $this->assertEquals(self::ISBN, $updateFirstPrintInfoRequest->getIsbn());
            $this->assertEquals(self::SUBTITLE, $updateFirstPrintInfoRequest->getSubtitle());
            $this->assertEquals(self::PUBLISHER, $updateFirstPrintInfoRequest->getPublisher());
            $this->assertEquals(self::COUNTRY, $updateFirstPrintInfoRequest->getCountry());
            $this->assertEquals(self::LANGUAGE, $updateFirstPrintInfoRequest->getLanguage());

            $publicationDate = $updateFirstPrintInfoRequest->getPublicationDate();
            $this->assertEquals(self::PUBLICATION_DATE_DAY, $publicationDate->getDay());
            $this->assertEquals(self::PUBLICATION_DATE_MONTH, $publicationDate->getMonth());
            $this->assertEquals(self::PUBLICATION_DATE_YEAR, $publicationDate->getYear());

            return true;
        }))->andReturn($this->firstPrintInfo);

        $this->action('PUT', 'FirstPrintInfoController@updateFirstPrintInfo', array(), $postData);

        $this->assertResponseOk();
    }

}