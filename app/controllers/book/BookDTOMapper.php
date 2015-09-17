<?php

class BookDTOMapper {

    public function mapToBookDTO($book){
        return new BookDTO($book->image, $book->title, $book->id);
    }

    public function mapBooksToBookDTO($books){
        $bookDTOs = array();
        foreach($books as $book){
            array_push($bookDTOs, new BookDTO($book->image, $book->title, $book->id));
        }
        return $bookDTOs;
    }
}