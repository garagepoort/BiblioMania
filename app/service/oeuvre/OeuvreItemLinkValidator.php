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
            throw new ServiceException('Author from oevre item is not an author from the book. Canot link');
        }
    }

}