<?php

class GiftInfoService {
	
	public function save($personal_book_info_id, $receipt_date, $occasion, $from){
        	$giftInfo = new GiftInfo();         
                $giftInfo->receipt_date = $receipt_date;
                $giftInfo->occasion = $occasion;
                $giftInfo->from = $from;
                $giftInfo->personal_book_info_id = $personal_book_info_id;
                
                $giftInfo->save();
                return $giftInfo;
	}
}