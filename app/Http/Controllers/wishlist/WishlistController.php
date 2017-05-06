<?php

use Bendani\PhpCommon\Utils\Exception\JsonException;

class WishlistController extends Controller
{

    /** @var  WishlistService */
    private $wishlistService;
    /** @var  JsonMappingService */
    private $jsonMappingService;

    /**
     * WishlistController constructor.
     */
    public function __construct()
    {
        $this->jsonMappingService = App::make('JsonMappingService');
        $this->wishlistService = App::make('WishlistService');
    }

    public function addBookToWishlist(){
        /** @var BookIdRequest $bookIdRequest */
        $bookIdRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->wishlistService->addBookToWishlist(Auth::user()->id, $bookIdRequest);
    }

    public function removeBookFromWishlist(){
        /** @var BookIdRequest $bookIdRequest */
        $bookIdRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->wishlistService->removeBookFromWishlist(Auth::user()->id, $bookIdRequest);
    }

}