<?php

class FileToBuyInfoParametersMapper {

    public function map($line_values){
        $buy_date = DateTime::createFromFormat('d-m-y', $line_values[LineMapping::$BuyInfoBuyDate]);
        if($buy_date == false){
            $buy_date = null;
        }

        return new BuyInfoParameters($buy_date,
            $line_values[LineMapping::$BuyInfoShop],
            "",
            "",
            "",
            $line_values[LineMapping::$BuyInfoPricePayed]);
    }
}
