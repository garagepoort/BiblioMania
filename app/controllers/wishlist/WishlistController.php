<?php

class WishlistController extends BaseController
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

    public function getWishListForUser($user_id){
        if(Auth::user()->id != $user_id){
            return new JsonException('Unauthorized', 403);
        }

        return array_map(
            function ($item) {
                $wishlistToJsonAdapter = new WishlistItemToJsonAdapter($item);
                return $wishlistToJsonAdapter->mapToJson();
            },
            $this->wishlistService->getWishlistForUser($user_id));
    }

    public function addBookToWishlist($user_id){
        if(Auth::user()->id != $user_id){
            return new JsonException('Unauthorized', 403);
        }

        /** @var BookIdRequest $bookIdRequest */
        $bookIdRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->wishlistService->addBookToWishlist($user_id, $bookIdRequest);
    }

    public function removeBookFromWishlist($user_id){
        if(Auth::user()->id != $user_id){
            return new JsonException('Unauthorized', 403);
        }

        /** @var BookIdRequest $bookIdRequest */
        $bookIdRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->wishlistService->removeBookFromWishlist($user_id, $bookIdRequest);
    }

}