<?php

class WishlistRepository
{

    public function find($id, $user_id)
    {
        return WishlistItem::where('user_id', '=', $user_id)
        ->where('id', '=', $id)
        ->first();
    }

    public function findByUserAndBook($user_id, $book_id)
    {
        return WishlistItem::where('user_id', '=', $user_id)
            ->where('book_id', '=', $book_id)
            ->first();
    }

    public function getWishListForUser($user_id, $with = array())
    {
        return WishlistItem::with($with)
            ->where('user_id', '=', $user_id)
            ->get();
    }

    public function save(WishlistItem $wishlistItem)
    {
        $wishlistItem->save();
        return $wishlistItem;
    }

    public function delete(WishlistItem $wishlistItem)
    {
        $wishlistItem->delete();
    }
}