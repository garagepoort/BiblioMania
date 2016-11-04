<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

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

    public function createReadingDate($userId, BaseReadingDateRequest $updateReadingDateRequest){
        return $this->fillInReadingDate($userId, $updateReadingDateRequest, new ReadingDate());
    }

    public function updateReadingDate($userId, UpdateReadingDateRequest $updateReadingDateRequest){
        $readingDate = $this->readingDateRepository->findByUserAndId($userId, $updateReadingDateRequest->getId());
        Ensure::objectNotNull('reading date', $readingDate);

        return $this->fillInReadingDate($userId, $updateReadingDateRequest, $readingDate);
    }

    public function deleteReadingDate($userId, $id){
        $readingDate = $this->readingDateRepository->findByUserAndId($userId, $id);
        Ensure::objectNotNull('reading date', $readingDate);

        $readingDate->load('personal_book_info');
        $book_id = $readingDate->personal_book_info->book_id;

        $this->readingDateRepository->deleteById($id);
        $this->bookElasticIndexer->indexBookById($book_id);
    }

    private function fillInReadingDate($userId, BaseReadingDateRequest $updateReadingDateRequest, $readingDate)
    {
        $personalBookInfo = $this->personalBookInfoRepository->findByUserAndId($userId, $updateReadingDateRequest->getPersonalBookInfoId());
        Ensure::objectNotNull('personal book info', $personalBookInfo);

        Ensure::objectNotNull('date of reading date', $updateReadingDateRequest->getDate());

        $dateString = $updateReadingDateRequest->getDate()->getDay() . "-" . $updateReadingDateRequest->getDate()->getMonth() . "-" . $updateReadingDateRequest->getDate()->getYear();
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