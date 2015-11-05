<?php

use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;

class BookGiftFromFilterHandler implements OptionsFilterHandler
{

    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder
            ->leftJoin("gift_info", "gift_info.personal_book_info_id", "=", "personal_book_info.id")
            ->whereIn("gift_info.from", $value);
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
        $gifters = $giftInfoService->getAllGifters();
        return $gifters;
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