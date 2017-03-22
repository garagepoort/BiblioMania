<?php

use Bendani\PhpCommon\Utils\StringUtils;

class GiftInfoService
{

    public function createOrUpdate($personalBookInfoId, GiftInfoRequest $createRequest)
    {
        $giftInfo = GiftInfo::where('personal_book_info_id', '=', $personalBookInfoId)->first();
        if($giftInfo == null) {
            $giftInfo = new GiftInfo();
        }

        $giftInfo->receipt_date = $createRequest->getGiftDate() == null ? null : DateFormatter::dateRequestToDateTime($createRequest->getGiftDate());
        $giftInfo->occasion = $createRequest->getOccasion();
        $giftInfo->reason = $createRequest->getReason();
        $giftInfo->from = $createRequest->getFrom();
        $giftInfo->personal_book_info_id = $personalBookInfoId;

        $giftInfo->save();
        return $giftInfo->id;
    }

    public function save($personal_book_info_id, $receipt_date, $occasion, $from, $reason)
    {
        $giftInfo = GiftInfo::where('personal_book_info_id', '=', $personal_book_info_id)->first();
        if ($giftInfo == null) {
            $giftInfo = new GiftInfo();
        }

        $giftInfo->receipt_date = $receipt_date;
        $giftInfo->occasion = $occasion;
        $giftInfo->from = $from;
        $giftInfo->reason = $reason;
        $giftInfo->personal_book_info_id = $personal_book_info_id;

        $giftInfo->save();
        return $giftInfo;
    }

    public function delete($personal_book_info_id)
    {
        $gift = GiftInfo::where('personal_book_info_id', '=', $personal_book_info_id)->first();
        if($gift != null){
            $gift->delete();
        }
    }

    public function getAllGifters(){
        return GiftInfo::select(DB::raw("gift_info.from"))
            ->join("personal_book_info", "gift_info.personal_book_info_id", '=',"personal_book_info.id")
            ->where('user_id', '=', Auth::user()->id)
            ->groupBy("gift_info.from")
            ->get();
    }
}