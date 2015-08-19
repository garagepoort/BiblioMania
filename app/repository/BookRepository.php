<?php

class BookRepository implements iRepository{

    public function find($id)
    {
        return Book::where('id', '=', $id)
            ->where('user_id', '=', Auth::user()->id)->first();
    }

    public function all()
    {
        return Book::all();
    }

    public function save($entity)
    {
        $entity->save();
    }

    public function delete($entity)
    {
        $entity->delete();
    }

    public function deleteById($id){
        return Book::find($id)->delete();
    }

    public function setLanguage(Book $book, Language $language = null){
        if ($language != null) {
            $book->language()->associate($language);
        } else {
            $book->language()->dissociate();
        }
    }

    public function setPublicationDate(Book $book, Date $publicationDate = null){
        if ($publicationDate != null) {
            $book->publication_date()->associate($publicationDate);
        } else {
            $book->publication_date()->dissociate();
        }
    }

    public function setPublisherSerie(Book $book, PublisherSerie $publisherSerie = null){
        if ($publisherSerie != null) {
            $book->publisher_serie()->associate($publisherSerie);
        } else {
            $book->publisher_serie()->dissociate();
        }
    }

    public function setBookSerie(Book $book, Serie $serie = null){
        if ($serie != null) {
            $book->serie()->associate($serie);
        } else {
            $book->serie()->dissociate();
        }
    }

    public function setBookFromAuthor(Book $book, BookFromAuthor $bookFromAuthor = null){
        if ($bookFromAuthor != null) {
            $book->book_from_author()->associate($bookFromAuthor);
        } else {
            $book->book_from_author()->dissociate();
        }
    }
}