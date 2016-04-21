<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

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
    /** @var  WishlistRepository */
    private $wishlistRepository;
    /** @var  BookElasticIndexer */
    private $bookElasticIndexer;

    function __construct()
    {
        $this->readingDateService = App::make('ReadingDateService');
        $this->bookRepository = App::make('BookRepository');
        $this->wishlistRepository = App::make('WishlistRepository');
        $this->personalBookInfoRepository = App::make('PersonalBookInfoRepository');
        $this->giftInfoService = App::make('GiftInfoService');
        $this->buyInfoService = App::make('BuyInfoService');
        $this->bookElasticIndexer = App::make('BookElasticIndexer');
    }

    public function find($id){
        return PersonalBookInfo::where('user_id', '=', Auth::user()->id)
            ->where('id', '=', $id)
            ->first();
    }

    public function createPersonalBookInfo($user_id, CreatePersonalBookInfoRequest $createRequest){
        return DB::transaction(function() use ($user_id, $createRequest){
            $book = $this->bookRepository->find($createRequest->getBookId());
            Ensure::objectNotNull('book', $book);
            $personalBookInfo = $this->personalBookInfoRepository->findByBook($createRequest->getBookId());
            Ensure::objectNull('personBookInformation', $personalBookInfo, 'The book given already has a personal book information. Cannot create a new one.');


            $personalBookInfo = new PersonalBookInfo();
            $personalBookInfo->book_id = $createRequest->getBookId();
            $personalBookInfo->user_id = $user_id;

            $updatePersonalBookInfoId = $this->updatePersonalBookInfo($personalBookInfo, $createRequest);
            $this->removeBookFromWishlist($user_id, $book);
            return $updatePersonalBookInfoId;
        });
    }

    public function update(UpdatePersonalBookInfoRequest $updateRequest){
        return DB::transaction(function() use ($updateRequest){
            $personalBookInfo = $this->personalBookInfoRepository->find($updateRequest->getId());
            Ensure::objectNotNull('personalBookInfo', $personalBookInfo);

            return $this->updatePersonalBookInfo($personalBookInfo, $updateRequest);
        });
    }

    private function updatePersonalBookInfo(PersonalBookInfo $personalBookInfo, BasePersonalBookInfoRequest $request){
        $personalBookInfo->set_owned($request->isInCollection());
        if(!$request->isInCollection()){
            $personalBookInfo->reason_not_owned = $request->getReasonNotInCollection();
            $this->giftInfoService->delete($personalBookInfo->id);
            $this->buyInfoService->delete($personalBookInfo->id);
        }else{
            if($request->getBuyInfo() == null && $request->getGiftInfo() == null){
                throw new ServiceException('Buy or gift information is not given');
            }
            if($request->getBuyInfo() != null && $request->getGiftInfo() != null){
                throw new ServiceException('Both buy and gift information are given. Only one can be chosen');
            }

            if($request->getBuyInfo() != null){
                $this->giftInfoService->delete($personalBookInfo->id);
                $this->buyInfoService->createOrUpdate($personalBookInfo->id, $request->getBuyInfo());
            }
            else{
                $this->buyInfoService->delete($personalBookInfo->id);
                $this->giftInfoService->createOrUpdate($personalBookInfo->id, $request->getGiftInfo());
            }
        }
        $personalBookInfo->save();

        $this->bookElasticIndexer->indexBook($personalBookInfo->book);
        return $personalBookInfo->id;
    }

    /**
     * @param $user_id
     * @param $book
     */
    function removeBookFromWishlist($user_id, $book)
    {
        $wishlistItem = $this->wishlistRepository->findByUserAndBook($user_id, $book->id);
        if ($wishlistItem !== null) {
            $this->wishlistRepository->delete($wishlistItem);
        }
    }
}