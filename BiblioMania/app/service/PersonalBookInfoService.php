<?php

class PersonalBookInfoService
{
    /** @var  ReadingDateService */
    private $readingDateService;

    function __construct()
    {
        $this->readingDateService = App::make('ReadingDateService');;
    }


    public function findOrCreate(PersonalBookInfoParameters $personalBookInfoParameters, Book $book){
        $personalBookInfo = PersonalBookInfo::where('book_id', '=', $book->id)->first();
        if ($personalBookInfo == null) {
            $personalBookInfo = new PersonalBookInfo();
        }
        $personalBookInfo->book_id = $book->id;
        $personalBookInfo->set_owned($personalBookInfoParameters->getOwned());
        $personalBookInfo->review = $personalBookInfoParameters->getReview();
        $personalBookInfo->rating = $personalBookInfoParameters->getRating();
        $personalBookInfo->read = count($personalBookInfoParameters->getReadingDates()) > 0;
        if(!$personalBookInfoParameters->getOwned()){
            $personalBookInfo->reason_not_owned = $personalBookInfoParameters->getReasonNotOwned();
        }
        $personalBookInfo->save();

        $this->syncReadingDates($personalBookInfoParameters, $personalBookInfo);

        return $personalBookInfo;
    }

    public function save($bookId, $owned, $reason_not_owned, $review, $rating, $reading_dates)
    {
        $personalInfoBook = PersonalBookInfo::where('book_id', '=', $bookId)->first();
        if ($personalInfoBook == null) {
            $personalInfoBook = new PersonalBookInfo();
        }

        $personalInfoBook->book_id = $bookId;
        $personalInfoBook->set_owned($owned);
        $personalInfoBook->review = $review;
        $personalInfoBook->rating = $rating;

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

    private function syncReadingDates(PersonalBookInfoParameters $personalBookInfoParameters, $personalBookInfo)
    {
        $reading_dates_ids = [];
        foreach ($personalBookInfoParameters->getReadingDates() as $date) {
            $readingDate = $this->readingDateService->saveOrFind($date);
            array_push($reading_dates_ids, $readingDate->id);
        }
        $personalBookInfo->reading_dates()->sync($reading_dates_ids);
    }
}