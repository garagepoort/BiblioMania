<?php

class BuyInfoImporter
{

    public static function importBuyInfo($personal_book_info_id, DateTime $buy_date = null, $price_payed, $shop)
    {
        /** @var BuyInfoService $buyInfoService */
        $buyInfoService = App::make('BuyInfoService');
        $buyInfo = $buyInfoService->save($personal_book_info_id, $buy_date, $price_payed, null, $shop, null, null);
        return $buyInfo;
    }
}