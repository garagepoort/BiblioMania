<?php

class GiftInfoImporter
{

    public static function importGiftInfo($personalBookInfoId, $from, $receipt_date)
    {
        /** @var GiftInfoService $giftInfoService */
        $giftInfoService = App::make('GiftInfoService');
        $giftInfo = $giftInfoService->save($personalBookInfoId, $receipt_date, null, $from, null);
        return $giftInfo;
    }
}