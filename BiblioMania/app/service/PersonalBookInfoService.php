<?php

class PersonalBookInfoService
{

    public function save($bookId, $owned, $reason_not_owned, $review, $rating, $retail_price, $reading_dates)
    {
        $personalInfoBook = PersonalBookInfo::where('book_id', '=', $bookId)->first();
        if ($personalInfoBook == null) {
            $personalInfoBook = new PersonalBookInfo();
        }

        $personalInfoBook->book_id = $bookId;
        $personalInfoBook->set_owned($owned);
        $personalInfoBook->review = $review;
        $personalInfoBook->rating = $rating;
        $personalInfoBook->retail_price = $retail_price;

        if ($owned == false) {
            $personalInfoBook->reason_not_owned = $reason_not_owned;
        }
        $personalInfoBook->save();

        /** @var ReadingDateService $readingDateService */
        $readingDateService = App::make('ReadingDateService');

        $reading_dates_ids = [];
        foreach ($reading_dates as $date) {
            $readingDate = $readingDateService->saveOrFind($date);
            array_push($reading_dates_ids, $readingDate->id);
        }
        $personalInfoBook->reading_dates()->sync($reading_dates_ids);
        return $personalInfoBook;
    }
}