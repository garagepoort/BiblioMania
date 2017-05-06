<?php

namespace tests\unit\controller;

use CreatePersonalBookInfoRequest;
use Mockery;
use PermissionService;
use PersonalBookInfo;
use PersonalBookInfoService;
use TestCase;
use User;

class PersonalBookInfoControllerCreateTest extends TestCase
{
    const USER_ID = 1;
    const BOOK_ID = 2;
    const PERSONAL_BOOK_INFO_ID = 123;
    const REASON_NOT_IN_COLLECTION = 'reasonNotInCollection';
    const REASON = 'buyReason';
    const SHOP = 'shop';
    const CITY_SHOP = 'cityShop';
    const COUNTRY_SHOP = 'countryShop';
    const AMOUNT = 45;
    const CURRENCY = 'EUR';
    const DAY = 29;
    const MONTH = 8;
    const YEAR = 2015;
    const FROM = 'giftFrom';
    const OCCASION = 'occasion';

    /** @var PersonalBookInfoService $personalBookInfoService */
    private $personalBookInfoService;
    /** @var PermissionService $permissionService */
    private $permissionService;

    public function setUp(){
        parent::setUp();

        $this->permissionService = $this->mock('PermissionService');
        $this->personalBookInfoService = $this->mock('PersonalBookInfoService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'CREATE_PERSONAL_BOOK_INFO')->andReturn(false);

        $response = $this->action('POST', 'PersonalBookInfoController@create', array(), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_creatingNotInCollection(){
        $this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'CREATE_PERSONAL_BOOK_INFO')->andReturn(true);
        $postData = array(
            'inCollection' => false,
            'reasonNotInCollection' => self::REASON_NOT_IN_COLLECTION,
            'bookId' => self::BOOK_ID
        );

        $this->personalBookInfoService->shouldReceive('createPersonalBookInfo')->once()->with(self::USER_ID, Mockery::on(function(CreatePersonalBookInfoRequest $createPersonalBookInfoRequest){
            $this->assertFalse($createPersonalBookInfoRequest->isInCollection());
            $this->assertEquals(self::BOOK_ID, $createPersonalBookInfoRequest->getBookId());
            $this->assertEquals(self::REASON_NOT_IN_COLLECTION, $createPersonalBookInfoRequest->getReasonNotInCollection());
            return true;
        }))->andReturn(self::PERSONAL_BOOK_INFO_ID);

        $response = $this->action('POST', 'PersonalBookInfoController@create', array(), $postData);

        $this->assertResponseOk();
        $this->assertEquals($response->getData()->id, self::PERSONAL_BOOK_INFO_ID);
    }

    public function test_creatingWithBuyInfo(){
        $this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'CREATE_PERSONAL_BOOK_INFO')->andReturn(true);

        $postData = array(
            'inCollection' => true,
            'bookId' => self::BOOK_ID,
            'buyInfo' => array(
                'buyDate' => array('day' => self::DAY, 'month' => self::MONTH, 'year' => self::YEAR),
                'buyPrice' => array('currency' => self::CURRENCY, 'amount' => self::AMOUNT),
                'reason' => self::REASON,
                'shop' => self::SHOP,
                'cityShop' => self::CITY_SHOP,
                'countryShop' => self::COUNTRY_SHOP,
            ),
        );

        $this->personalBookInfoService->shouldReceive('createPersonalBookInfo')->once()->with(self::USER_ID, Mockery::on(function(CreatePersonalBookInfoRequest $createPersonalBookInfoRequest){
            $this->assertTrue($createPersonalBookInfoRequest->isInCollection());
            $this->assertEquals(self::BOOK_ID, $createPersonalBookInfoRequest->getBookId());
            $this->assertEquals(self::DAY, $createPersonalBookInfoRequest->getBuyInfo()->getBuyDate()->getDay());
            $this->assertEquals(self::MONTH, $createPersonalBookInfoRequest->getBuyInfo()->getBuyDate()->getMonth());
            $this->assertEquals(self::YEAR, $createPersonalBookInfoRequest->getBuyInfo()->getBuyDate()->getYear());
            $this->assertEquals(self::CURRENCY, $createPersonalBookInfoRequest->getBuyInfo()->getBuyPrice()->getCurrency());
            $this->assertEquals(self::AMOUNT, $createPersonalBookInfoRequest->getBuyInfo()->getBuyPrice()->getAmount());
            $this->assertEquals(self::REASON, $createPersonalBookInfoRequest->getBuyInfo()->getReason());
            $this->assertEquals(self::SHOP, $createPersonalBookInfoRequest->getBuyInfo()->getShop());
            $this->assertEquals(self::COUNTRY_SHOP, $createPersonalBookInfoRequest->getBuyInfo()->getCountryShop());
            $this->assertEquals(self::CITY_SHOP, $createPersonalBookInfoRequest->getBuyInfo()->getCityShop());
            return true;
        }))->andReturn(self::PERSONAL_BOOK_INFO_ID);

        $response = $this->action('POST', 'PersonalBookInfoController@create', array(), $postData);

        $this->assertResponseOk();
        $this->assertEquals($response->getData()->id, self::PERSONAL_BOOK_INFO_ID);
    }

    public function test_creatingWithGiftInfo(){
        $this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'CREATE_PERSONAL_BOOK_INFO')->andReturn(true);

        $postData = array(
            'inCollection' => true,
            'bookId' => self::BOOK_ID,
            'giftInfo' => array(
                'giftDate' => array('day' => self::DAY, 'month' => self::MONTH, 'year' => self::YEAR),
                'reason' => self::REASON,
                'occasion' => self::OCCASION,
                'from' => self::FROM
            ),
        );

        $this->personalBookInfoService->shouldReceive('createPersonalBookInfo')->once()->with(self::USER_ID, Mockery::on(function(CreatePersonalBookInfoRequest $createPersonalBookInfoRequest){
            $this->assertTrue($createPersonalBookInfoRequest->isInCollection());
            $this->assertEquals(self::BOOK_ID, $createPersonalBookInfoRequest->getBookId());
            $this->assertEquals(self::DAY, $createPersonalBookInfoRequest->getGiftInfo()->getGiftDate()->getDay());
            $this->assertEquals(self::MONTH, $createPersonalBookInfoRequest->getGiftInfo()->getGiftDate()->getMonth());
            $this->assertEquals(self::YEAR, $createPersonalBookInfoRequest->getGiftInfo()->getGiftDate()->getYear());

            $this->assertEquals(self::REASON, $createPersonalBookInfoRequest->getGiftInfo()->getReason());
            $this->assertEquals(self::FROM, $createPersonalBookInfoRequest->getGiftInfo()->getFrom());
            $this->assertEquals(self::OCCASION, $createPersonalBookInfoRequest->getGiftInfo()->getOccasion());
            return true;
        }))->andReturn(self::PERSONAL_BOOK_INFO_ID);

        $response = $this->action('POST', 'PersonalBookInfoController@create', array(), $postData);

        $this->assertResponseOk();
        $this->assertEquals($response->getData()->id, self::PERSONAL_BOOK_INFO_ID);
    }
}