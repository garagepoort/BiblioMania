<?php

class WishlistItemToJsonAdapter
{
    /** @var  integer */
    private $id;
    /** @var BookToJsonAdapter */
    private $bookToJsonAdapter;

    /**
     * WishlistItemToJsonAdapter constructor.
     * @param WishlistItem $wishlistItem
     */
    public function __construct(WishlistItem $wishlistItem)
    {
        $this->id = $wishlistItem->id;
        $this->bookToJsonAdapter = new BookToJsonAdapter($wishlistItem->book);
    }


    public function mapToJson(){
        return array(
            "id"=>$this->id,
            "book"=>$this->bookToJsonAdapter->mapToJson()
        );
    }
}