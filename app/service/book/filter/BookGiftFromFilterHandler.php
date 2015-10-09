<?php

class BookGiftFromFilterHandler implements OptionsFilterHandler
{

    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder->whereIn("gift_info.from", $value);
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
//        $options = array();
//        foreach($publishers as $publisher){
//            $options[$publisher->name] = $publisher->id;
//        }
        return $gifters;
    }

    public function getSupportedOperators()
    {
        return array("in"=>FilterOperator::IN);
    }
}