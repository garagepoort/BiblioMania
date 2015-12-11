<?php

class PersonalBookInfoService
{
    /** @var  ReadingDateService */
    private $readingDateService;

    /** @var  BookRepository */
    private $bookRepository;
    /** @var  PersonalBookInfoRepository */
    private $personalBookInfoRepository;
    /** @var  BuyInfoService */
    private $buyInfoService;
    /** @var  GiftInfoService */
    private $giftInfoService;

    function __construct()
    {
        $this->readingDateService = App::make('ReadingDateService');
        $this->bookRepository = App::make('BookRepository');
        $this->personalBookInfoRepository = App::make('PersonalBookInfoRepository');
        $this->giftInfoService = App::make('GiftInfoService');
        $this->buyInfoService = App::make('BuyInfoService');
    }

    public function find($id){
        return PersonalBookInfo::where('user_id', '=', Auth::user()->id)
            ->where('personal_book_info.id', '=', $id)
            ->first();
    }

    public function createPersonalBookInfo(CreatePersonalBookInfoRequest $createRequest){
        $book = $this->bookRepository->find($createRequest->getBookId());
        Ensure::objectNotNull('book', $book);
        $personalBookInfo = $this->personalBookInfoRepository->findByBook($createRequest->getBookId());
        Ensure::objectNull('personBookInformation', $personalBookInfo, 'The book given already has a personal book information. Cannot create a new one.');

        if($createRequest->getBuyInfo() == null && $createRequest->getGiftInfo() == null){
            throw new ServiceException('No buy or gift information given');
        }
        if($createRequest->getBuyInfo() != null && $createRequest->getGiftInfo() != null){
            throw new ServiceException('Both buy and gift information are given. Only one can be chosen');
        }

        $personalBookInfo = new PersonalBookInfo();
        $personalBookInfo->book_id = $createRequest->getBookId();
        $personalBookInfo->user_id = Auth::user()->id;
        return $this->updatePersonalBookInfo($personalBookInfo, $createRequest);
    }

    public function update(UpdatePersonalBookInfoRequest $updateRequest){
        $personalBookInfo = $this->personalBookInfoRepository->find($updateRequest->getId());
        Ensure::objectNotNull('personalBookInfo', $personalBookInfo);

        if($updateRequest->getBuyInfo() == null && $updateRequest->getGiftInfo() == null){
            throw new ServiceException('No buy or gift information given');
        }
        if($updateRequest->getBuyInfo() != null && $updateRequest->getGiftInfo() != null){
            throw new ServiceException('Both buy and gift information are given. Only one can be chosen');
        }

        return $this->updatePersonalBookInfo($personalBookInfo, $updateRequest);
    }

    private function updatePersonalBookInfo(PersonalBookInfo $personalBookInfo, BasePersonalBookInfoRequest $request){
        $personalBookInfo->review = $request->getReview();
        $personalBookInfo->rating = $request->getRating();

        $personalBookInfo->set_owned($request->isInCollection());
        if(!$request->isInCollection()){
            $personalBookInfo->reason_not_owned = $request->getReasonNotInCollection();
        }

        $personalBookInfo->save();

        if($request->getBuyInfo() != null){
            $this->giftInfoService->delete($personalBookInfo->id);
            $this->buyInfoService->createOrUpdate($personalBookInfo->id, $request->getBuyInfo());
        }
        else{
            $this->buyInfoService->delete($personalBookInfo->id);
            $this->giftInfoService->createOrUpdate($personalBookInfo->id, $request->getGiftInfo());
        }

        return $personalBookInfo->id;
    }

    public function addReadingDate($personalBookInfoId, DateRequest $date){
        $personalBookInfo = $this->find($personalBookInfoId);
        Ensure::objectNotNull('personal book info', $personalBookInfoId);

        $readingDate = $this->readingDateService->create($date);
        $personalBookInfo->reading_dates()->attach($readingDate->id);
    }

    public function deleteReadingDate($personalBookInfoId, DeleteReadingDateRequest $deleteReadingDateRequest){
        $personalBookInfo = $this->find($personalBookInfoId);
        Ensure::objectNotNull('personal book info', $personalBookInfoId);

        $readingDate = $this->readingDateService->find($deleteReadingDateRequest->getReadingDateId());
        Ensure::objectNotNull('reading date', $readingDate);

        $personalBookInfo->reading_dates()->detach($deleteReadingDateRequest->getReadingDateId());
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