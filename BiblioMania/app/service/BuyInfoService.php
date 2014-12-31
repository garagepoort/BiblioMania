<?php

class BuyInfoService {
	
	public function save($personal_book_info_id, $buy_date, $price_payed, $recommended_by, $shop, $cityName, $countryId){
		$buyInfo = new BuyInfo();         
               
                if(!is_null($cityName)){
                        $city = App::make('CityService')->save($cityName, $countryId);
                        $buyInfo->city_id = $city->id;
                }

                $buyInfo->buy_date = $buy_date;
                $buyInfo->price_payed = $price_payed;
                $buyInfo->recommended_by = $recommended_by;
                $buyInfo->shop = $shop;
                $buyInfo->personal_book_info_id = $personal_book_info_id;
                
                $buyInfo->save();

                return $buyInfo;
	}
}