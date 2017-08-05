<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;
use Bendani\PhpCommon\Utils\StringUtils;

class BookBuyShopFilter implements OptionsFilter
{
    /** @var  BuyInfoService $buyInfoService */
    private $buyInfoService;
    /**
     * BookCountryFilterHandler constructor.
     */
    public function __construct()
    {
        $this->buyInfoService = App::make('BuyInfoService');
    }

    public function getFilterId()
    {
        return FilterType::BOOK_BUY_SHOP;
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Winkel aankoop";
    }

    public function getOptions()
    {
        $options= array();
        $noValueOption = array("key" => "Geen waarde", "value" => "");
        array_push($options, $noValueOption);
        foreach($this->buyInfoService->getAllShops() as $shop){
            if(!StringUtils::isEmpty($shop)){
                array_push($options, array("key"=>$shop, "value"=>$shop));
            }else{
                $noValueOption["value"] = $shop;
            }
        }
        return $options;
    }

    public function getSupportedOperators()
    {
        return null;
    }

    public function getGroup()
    {
        return "personal";
    }
}