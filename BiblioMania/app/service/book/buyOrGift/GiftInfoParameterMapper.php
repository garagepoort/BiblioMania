<?php

class GiftInfoParameterMapper {

    public function create(){
        $receipt_date = DateTime::createFromFormat('d/m/Y', Input::get('gift_info_receipt_date'));
        if ($receipt_date == false) {
            $receipt_date = null;
        }
        return new GiftInfoParameters(
            $receipt_date,
            Input::get('gift_info_from'),
            Input::get('gift_info_occasion'));
    }
}