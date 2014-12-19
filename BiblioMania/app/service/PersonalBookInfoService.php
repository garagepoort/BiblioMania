<?php
class PersonalBookInfoService {

	public function save($bookId, $owned, $review, $rating, $retail_price, $reading_dates){
		$personalInfoBook = new PersonalBookInfo();

                $personalInfoBook->book_id = $bookId;
                $personalInfoBook->set_owned($owned);
                $personalInfoBook->review = $review;
                $personalInfoBook->rating = $rating;
                $personalInfoBook->retail_price = $retail_price;
                $personalInfoBook->save();

                $readingDateService = App::make('ReadingDateService');

                foreach ($reading_dates as $date) {
                        $readingDate = $readingDateService->saveOrFind($date);
                        $personalInfoBook->reading_dates()->sync([$readingDate->id], false);
                }
                return $personalInfoBook;
	}
}