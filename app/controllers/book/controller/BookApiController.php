<?php

class BookApiController extends BaseController
{
    /** @var  BookRepository */
    private $bookRepository;
    /** @var ApiAuthenticationService */
    private $apiAuthenticationService;

    public function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->apiAuthenticationService = App::make('ApiAuthenticationService');
    }

    public function index(){
        $error = $this->apiAuthenticationService->checkUserAuthenticated();
        if($error != null){
            return $error;
        }else{
            $user = $this->apiAuthenticationService->getUser();
            return array_map(function($book){
                $adapter = new FullBookToJsonAdapter($book);
                return $adapter->mapToJson();
            }, $this->bookRepository->allFromUser($user->id, array('personal_book_infos', 'authors', 'book_from_authors'))->all());
        }
    }

}