<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */
class ShopController extends BaseController
{

    /** @var BuyInfoService $buyInfoService */
    private $buyInfoService;

    function __construct()
    {
        $this->buyInfoService = App::make('BuyInfoService');
    }

    public function getShops(){
        return $this->buyInfoService->getAllShops();
    }
}