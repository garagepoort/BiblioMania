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
        $user = $this->apiAuthenticationService->checkUserAuthenticated();
        if($user != null){
            return $user;
        }else{
            return $this->bookService->getAllFullBooks();
        }
    }

}