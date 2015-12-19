<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookGiftFromFilterHandler implements OptionsFilterHandler
{

    public function handleFilter($queryBuilder, Filter $filter)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){
            return $item->value;
        }, (array) $filter->getValue());

        return $queryBuilder
            ->leftJoin("gift_info", "gift_info.personal_book_info_id", "=", "personal_book_info.id")
            ->whereIn("gift_info.from", $options);
    }

    public function getFilterId()
    {
        return "buy-gift-from";
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

    public function getSupportedOperators()
    {
        return array(
            array("key"=>"in", "value"=>FilterOperator::IN)
        );
    }

    public function getGroup()
    {
        return "buy-gift";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}