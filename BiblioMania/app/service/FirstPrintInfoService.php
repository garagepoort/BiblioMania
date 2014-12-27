<?php 
class FirstPrintInfoService {

	public function saveOrUpdate($title, $subtitle, $isbn, $publication_date, $publisherName, $countryId, $languageId){
		$publication_date_id = null;
        $firstPrintInfo = null;
        if(!is_null($publication_date)){
            $publication_date_id = $publication_date->id;
        }
        if(!is_null($isbn)){
            $firstPrintInfo = FirstPrintInfo::where('ISBN', '=', $isbn)
	            ->first();
        }

        if (is_null($firstPrintInfo)) {
            	$firstPrintInfo = new FirstPrintInfo();
        }

        $publisher = App::make('PublisherService')->saveOrUpdate($publisherName, Country::find($countryId));

        $firstPrintInfo->title = $title;
        $firstPrintInfo->subtitle = $subtitle;
        $firstPrintInfo->publication_date_id = $publication_date_id;
        $firstPrintInfo->publisher_id = $publisher->id;
        $firstPrintInfo->ISBN = $isbn;
        $firstPrintInfo->country_id = $countryId;
        $firstPrintInfo->language_id = $languageId;

        $firstPrintInfo->save();
        return $firstPrintInfo;
	}
}