<?php

class GiftInfoService
{

    public function findOrCreate(GiftInfoParameters $giftInfoParameters, PersonalBookInfo $personalBookInfo){
        $giftInfo = GiftInfo::where('personal_book_info_id', '=', $personalBookInfo->id)->first();
        if ($giftInfo == null) {
            $giftInfo = new GiftInfo();
        }
        $giftInfo->receipt_date = $giftInfoParameters->getDate();
        $giftInfo->occasion = $giftInfoParameters->getOccasion();
        $giftInfo->reason = $giftInfoParameters->getReason();
        $giftInfo->from = $giftInfoParameters->getFrom();
        $giftInfo->personal_book_info_id = $personalBookInfo->id;

        $giftInfo->save();
        return $giftInfo;
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
        $giftInfos = GiftInfo::select(DB::raw("gift_info.from"))
            ->join("personal_book_info", "gift_info.personal_book_info_id", '=',"personal_book_info.id")
            ->join("book", "personal_book_info.book_id", '=', "book.id")
            ->where('book.user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->groupBy("gift_info.from")
            ->get();

        $result = array();
        foreach($giftInfos as $gifter){
            if(!StringUtils::isEmpty($gifter->from)){
                $result[$gifter->from] = $gifter->from;
            }
        }

        return $result;
    }
}