<?php

class BookApiController extends Controller
{
    /** @var  BookRepository */
    private $bookRepository;
    /** @var ApiAuthenticationService */
    private $apiAuthenticationService;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;
    /** @var  ReadingDateService $readingDateService */
    private $readingDateService;

    public function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->apiAuthenticationService = App::make('ApiAuthenticationService');
        $this->jsonMappingService = App::make('JsonMappingService');
        $this->readingDateService = App::make('ReadingDateService');
    }

    public function getBooks(){
        $user = $this->apiAuthenticationService->getUser();
        return array_map(function($book){
            $adapter = new FullBookToJsonAdapter($book);
            return $adapter->mapToJson();
        }, $this->bookRepository->allFromUser($user->id, array('personal_book_infos', 'authors', 'book_from_authors'))->all());
    }

    public function createReadingDate(){
        $user = $this->apiAuthenticationService->getUser();
        $date = $this->jsonMappingService->mapInputToJson(Input::get(), new ReadingDateFromJsonAdapter());
        $id = $this->readingDateService->createReadingDate($user->id, $date);
        return Response::json(array('success' => true, 'id' => $id), 200);
    }

}