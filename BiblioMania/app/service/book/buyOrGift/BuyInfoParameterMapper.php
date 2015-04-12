<?php

class BuyInfoParameterMapper {

    public function create(){
        $buy_date = DateTime::createFromFormat('d/m/Y', Input::get('buy_info_buy_date'));
        if ($buy_date == false) {
            $buy_date = null;
        }

        return new BuyInfoParameters($buy_date,
            Input::get('buy_info_shop'),
            Input::get('buy_info_city'),
            Input::get('buy_info_recommended_by'),
            Input::get('buy_info_country'),
            Input::get('buy_info_price_payed')
        );
    }
}