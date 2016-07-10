<?php

class BookApiController extends BaseController
{
    /** @var  BookService */
    private $bookService;
    /** @var ApiAuthenticationService */
    private $apiAuthenticationService;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->apiAuthenticationService = App::make('ApiAuthenticationService');
    }

    public function index(){
        $error = $this->apiAuthenticationService->checkUserAuthenticated();
        if($error != null){
            return $error;
        }else{
            return $this->bookService->searchAllBooks(Auth::user()->id, array());
        }
    }

}