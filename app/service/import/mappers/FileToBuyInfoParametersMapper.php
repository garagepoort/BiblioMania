<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class FileToBuyInfoParametersMapper {

    public function map($line_values){
        $buy_date = DateTime::createFromFormat('d/m/Y', $line_values[LineMapping::$BuyInfoBuyDate]);
        if($buy_date == false){
            $buy_date = null;
        }

        $pricePayed = $line_values[LineMapping::$BuyInfoPricePayed];
        $pricePayed = StringUtils::replace($pricePayed, "€", "");
        $pricePayed = StringUtils::replace($pricePayed, " ", "");

        return new BuyInfoParameters($buy_date,
            $line_values[LineMapping::$BuyInfoShop],
            "",
            "",
            "",
            $pricePayed,
            'EUR');
    }
}
