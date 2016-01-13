<?php

class ReadingDateService
{
    /** @var  PersonalBookInfoRepository */
    private $personalBookInfoRepository;
    /** @var  ReadingDateRepository */
    private $readingDateRepository;
    /** @var  BookElasticIndexer */
    private $bookElasticIndexer;
    public function __construct()
    {
        $this->personalBookInfoRepository = App::make('PersonalBookInfoRepository');
        $this->readingDateRepository = App::make('ReadingDateRepository');
        $this->bookElasticIndexer = App::make('BookElasticIndexer');
    }

    public function createReadingDate(BaseReadingDateRequest $updateReadingDateRequest){
        return $this->fillInReadingDate($updateReadingDateRequest, new ReadingDate());
    }

    public function updateReadingDate(UpdateReadingDateRequest $updateReadingDateRequest){
        $readingDate = $this->readingDateRepository->find($updateReadingDateRequest->getId());
        Ensure::objectNotNull('reading date', $readingDate);

        return $this->fillInReadingDate($updateReadingDateRequest, $readingDate);
    }

    public function deleteReadingDate($id){
        $readingDate = $this->readingDateRepository->find($id);
        Ensure::objectNotNull('reading date', $readingDate);

        $book_id = $readingDate->personal_book_info->book_id;

        $this->readingDateRepository->deleteById($id);
        $this->bookElasticIndexer->indexBookById($book_id);
    }

    /**
     * @param BaseReadingDateRequest $updateReadingDateRequest
     * @param $readingDate
     * @return mixed
     * @throws ServiceException
     */
    private function fillInReadingDate(BaseReadingDateRequest $updateReadingDateRequest, $readingDate)
    {
        $personalBookInfo = $this->personalBookInfoRepository->find($updateReadingDateRequest->getPersonalBookInfoId());
        Ensure::objectNotNull('personal book info', $personalBookInfo);

        Ensure::objectNotNull('date of reading date', $updateReadingDateRequest->getDate());

        $dateString = $updateReadingDateRequest->getDate()->getDay() . "-" . +$updateReadingDateRequest->getDate()->getMonth() . "-" . $updateReadingDateRequest->getDate()->getYear();
        $datetime = DateTime::createFromFormat('d-m-Y', $dateString);

        $readingDate->rating = $updateReadingDateRequest->getRating();
        $readingDate->review = $updateReadingDateRequest->getReview();
        $readingDate->personal_book_info_id = $updateReadingDateRequest->getPersonalBookInfoId();
        $readingDate->date = $datetime;

        $readingDate->save();
        $this->bookElasticIndexer->indexBookById($personalBookInfo->book_id);
        return $readingDate->id;
    }
}