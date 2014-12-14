<?php 
class FirstPrintInfoService {

	public function saveOrUpdate($title, $subtitle, $isbn, $publication_date, $publisherName, $countryId, $languageId){
		$firstPrintInfo = FirstPrintInfo::where('isbn', '=', $isbn)
	            ->first();

        if (is_null($firstPrintInfo)) {
            	$firstPrintInfo = new FirstPrintInfo();
        }

        $publisher = App::make('PublisherService')->saveOrUpdate($publisherName, Country::find($countryId));

        $firstPrintInfo->title = $title;
        $firstPrintInfo->subtitle = $subtitle;
        $firstPrintInfo->publication_date = $publication_date;
        $firstPrintInfo->publisher_id = $publisher->id;
        $firstPrintInfo->ISBN = $isbn;
        $firstPrintInfo->country_id = $countryId;
        $firstPrintInfo->language_id = $languageId;

        $firstPrintInfo->save();
        return $firstPrintInfo;
	}
}