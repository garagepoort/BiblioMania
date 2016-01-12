<?php

class WishlistService
{

    /** @var  WishlistRepository */
    private $wishlistRepository;
    /** @var  UserRepository */
    private $userRepository;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  BookElasticIndexer */
    private $bookElasticIndexer;

    public function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->userRepository = App::make('UserRepository');
        $this->wishlistRepository = App::make('WishlistRepository');
        $this->bookElasticIndexer = App::make('BookElasticIndexer');
    }

    public function getWishlistForUser($user_id){
        return $this->wishlistRepository->getWishListForUser($user_id)->all();
    }

    public function isBookInWishlistOfUser($user_id, $book_id){
        $wishlistItem = $this->wishlistRepository->findByUserAndBook($user_id, $book_id);
        return $wishlistItem !== null;
    }

    public function addBookToWishlist($user_id, BookIdRequest $bookIdRequest){
        $user = $this->userRepository->find($user_id);
        Ensure::objectNotNull('user', $user);
        $book = $this->bookRepository->find($bookIdRequest->getBookId());
        Ensure::objectNotNull('book', $book);

        $wishlistItem = $this->wishlistRepository->findByUserAndBook($user_id, $bookIdRequest->getBookId());
        Ensure::objectNull('wishlist item', $wishlistItem, 'This wishlist already contains this book. Can not add.');


        $wishlistItem = new WishlistItem();
        $wishlistItem->user_id = $user_id;
        $wishlistItem->book_id = $bookIdRequest->getBookId();
        $this->wishlistRepository->save($wishlistItem);
        $this->bookElasticIndexer->indexBook($book);
    }

    public function removeBookFromWishlist($user_id, BookIdRequest $bookIdRequest)
    {
        $user = $this->userRepository->find($user_id);
        Ensure::objectNotNull('user', $user);
        $book = $this->bookRepository->find($bookIdRequest->getBookId());
        Ensure::objectNotNull('book', $book);

        $wishlistItem = $this->wishlistRepository->findByUserAndBook($user_id, $bookIdRequest->getBookId());
        Ensure::objectNotNull('wishlist item', $wishlistItem, 'This user does not have the given book on his wishlist. Can not remove book.');

        $this->wishlistRepository->delete($wishlistItem);
        $this->bookElasticIndexer->indexBook($wishlistItem->book);
    }
}