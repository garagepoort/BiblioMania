<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\Utils\StringUtils;

class BookGiftFromFilter implements Filter
{

    public function getFilterId()
    {
        return FilterType::BOOK_BUY_GIFT_FROM;
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Gekregen van";
    }

    public function getOptions()
    {
        /** @var GiftInfoService $giftInfoService */
        $giftInfoService = App::make("GiftInfoService");

        $options= array();
        $noValueOption = array("key" => "Geen waarde", "value" => "");
        array_push($options, $noValueOption);
        foreach($giftInfoService->getAllGifters() as $gifter){
            if(!StringUtils::isEmpty($gifter->from)){
                array_push($options, array("key"=>$gifter->from, "value"=>$gifter->from));
            }else{
                $noValueOption["value"] = $gifter->from;
            }
        }
        return $options;
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "personal";
    }
}