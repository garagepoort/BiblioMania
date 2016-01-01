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
            ->where('id', '=', $id)
            ->first();
    }

    public function createPersonalBookInfo(CreatePersonalBookInfoRequest $createRequest){
        return DB::transaction(function() use ($createRequest){
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
        });
    }

    public function update(UpdatePersonalBookInfoRequest $updateRequest){
        return DB::transaction(function() use ($updateRequest){
            $personalBookInfo = $this->personalBookInfoRepository->find($updateRequest->getId());
            Ensure::objectNotNull('personalBookInfo', $personalBookInfo);

            if($updateRequest->getBuyInfo() == null && $updateRequest->getGiftInfo() == null){
                throw new ServiceException('No buy or gift information given');
            }
            if($updateRequest->getBuyInfo() != null && $updateRequest->getGiftInfo() != null){
                throw new ServiceException('Both buy and gift information are given. Only one can be chosen');
            }

            return $this->updatePersonalBookInfo($personalBookInfo, $updateRequest);
        });
    }

    private function updatePersonalBookInfo(PersonalBookInfo $personalBookInfo, BasePersonalBookInfoRequest $request){
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
}