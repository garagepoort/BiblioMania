<?php

class OeuvreItemLinkValidator
{

    public function validate($oeuvreItem, $book){
        $valid = false;
        foreach($book->authors as $author){
            if($author->id === $oeuvreItem->author->id){
                $valid = true;
            }
        }
        if(!$valid){
            throw new ServiceException('Author from oeuvre item is not an author from the book. Cannot link');
        }

        foreach($book->book_from_authors as $bookFromAuthor){
            if($bookFromAuthor->id === $oeuvreItem->id){
                throw new ServiceException('Book is already linked to the given oeuvreItem');
            }
        }
    }

}