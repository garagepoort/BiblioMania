<?php

use Bendani\PhpCommon\Utils\StringUtils;

class BuyInfoService
{
    /** @var  CityService */
    private $cityService;
    /** @var  CountryService */
    private $countryService;

    function __construct()
    {
        $this->cityService = App::make('CityService');
        $this->countryService = App::make('CountryService');
    }


    public function createOrUpdate($personBookInfoId, BuyInfoRequest $createRequest)
    {
        $buyInfo = BuyInfo::where('personal_book_info_id', '=', $personBookInfoId)->first();
        if($buyInfo == null){
            $buyInfo = new BuyInfo();
        }

        if(!StringUtils::isEmpty($createRequest->getCountryShop())){
            $country = $this->countryService->findOrCreate($createRequest->getCountryShop());
            $buyInfo->country_id = $country->id;

            if(!StringUtils::isEmpty($createRequest->getCityShop())){
                $city = $this->cityService->save($createRequest->getCityShop(), $country->id);
                $buyInfo->city_id = $city->id;
            }
        }

        if($createRequest->getBuyPrice() != null){
            $buyInfo->price_payed = $createRequest->getBuyPrice()->getAmount();
            $buyInfo->currency = $createRequest->getBuyPrice()->getCurrency();
        }

        $buyInfo->buy_date = $createRequest->getBuyDate() == null ? null : DateFormatter::dateRequestToDateTime($createRequest->getBuyDate());
        $buyInfo->reason = $createRequest->getReason();
        $buyInfo->shop = $createRequest->getShop();
        $buyInfo->personal_book_info_id = $personBookInfoId;

        $buyInfo->save();

        return $buyInfo->id;
    }

    public function findOrCreate(BuyInfoParameters $buyInfoParameters, PersonalBookInfo $personalBookInfo){
        $buyInfo = BuyInfo::where('personal_book_info_id', '=', $personalBookInfo->id)->first();
        if ($buyInfo == null) {
            $buyInfo = new BuyInfo();
        }

        $country = null;
        if(!StringUtils::isEmpty($buyInfoParameters->getCountry())){
            $country = $this->countryService->findOrCreate($buyInfoParameters->getCountry());
            $buyInfo->country_id = $country->id;
        }

        if (!is_null($buyInfoParameters->getCity()) && !is_null($country)) {
            $city = $this->cityService->save($buyInfoParameters->getCity(), $country->id);
            $buyInfo->city_id = $city->id;
        }

        $buyInfo->buy_date = $buyInfoParameters->getDate();
        $buyInfo->price_payed = $buyInfoParameters->getPricePayed();
        $buyInfo->reason = $buyInfoParameters->getReason();
        $buyInfo->shop = $buyInfoParameters->getShop();
        $buyInfo->currency = $buyInfoParameters->getCurrency();
        $buyInfo->personal_book_info_id = $personalBookInfo->id;

        $buyInfo->save();

        return $buyInfo;
    }

    public function save($personal_book_info_id, DateTime $buy_date = null, $price_payed, $reason, $shop, $cityName, $countryId)
    {
        $buyInfo = BuyInfo::where('personal_book_info_id', '=', $personal_book_info_id)->first();
        if ($buyInfo == null) {
            $buyInfo = new BuyInfo();
        }

        if (!is_null($cityName)) {
            $city = App::make('CityService')->save($cityName, $countryId);
            $buyInfo->city_id = $city->id;
        }

        $buyInfo->buy_date = $buy_date;
        $buyInfo->price_payed = $price_payed;
        $buyInfo->reason = $reason;
        $buyInfo->shop = $shop;
        $buyInfo->personal_book_info_id = $personal_book_info_id;

        $buyInfo->save();

        return $buyInfo;
    }

    public function delete($personal_book_info_id){
        $buyInfo = BuyInfo::where('personal_book_info_id', '=', $personal_book_info_id)->first();
        if($buyInfo != null){
            $buyInfo->delete();
        }
    }

    public function getAllShops(){
        $buyInfos = BuyInfo::distinct()->select('shop')->where('shop', '!=', '')->groupBy('shop')->get()->toArray();
        return array_map(function ($item) {
            return $item['shop'];
        }, $buyInfos);
    }

}