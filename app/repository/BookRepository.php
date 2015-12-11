<?php

class BookRepository implements Repository{

    public function find($id, $with = array())
    {
        return Book::with($with)
            ->where('id', '=', $id)
            ->first();
    }

    public function deleteBookById($id){
        $this->find($id)->delete();
    }

    public function findCompleted($id, $with = array())
    {
        return Book::with($with)
            ->where('id', '=', $id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->first();
    }

    public function findDraft($id, $with = array())
    {
        return Book::with($with)
            ->where('id', '=', $id)
            ->where('wizard_step', '!=', 'COMPLETE')
            ->first();
    }

    public function allCompletedPaginated($id, $pages, $with = array())
    {
        return Book::with($with)
            ->where('id', '=', $id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->paginate($pages);
    }

    public function allDraftsPaginated($id, $pages, $with = array())
    {
        return Book::with($with)
            ->where('id', '=', $id)
            ->where('wizard_step', '!=', 'COMPLETE')
            ->paginate($pages);
    }

    public function all()
    {
        return Book::all();
    }

    public function allCompleted($with = array())
    {
        return Book::with($with)
            ->where('wizard_step', '=', 'COMPLETE')
            ->get();
    }

    public function allDrafts($with = array())
    {
        return Book::with($with)
            ->where('wizard_step', '!=', 'COMPLETE')
            ->get();
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
        $book->save();
    }

    public function getTotalAmountOfBooksOwned(){
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->where('wizard_step', '=', 'COMPLETE')
            ->where('personal_book_info.owned', '=', 1)
            ->count();
    }

    public function getTotalAmountOfBooksInLibrary(){
        return DB::table('book')
            ->where('wizard_step', '=', 'COMPLETE')
            ->count();
    }

    public function getValueOfLibrary(){
        return DB::table('book')
            ->where('wizard_step', '=', 'COMPLETE')
            ->sum('retail_price');
    }

    public function getAllTranslators(){
        $books = Book::distinct()->select('translator')->where('translator', '!=', '')->groupBy('translator')->get()->toArray();
        return array_map(function ($object) {
            return $object['translator'];
        }, $books);
    }

    public function getTotalAmountOfBooksRead()
    {
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->where('wizard_step', '=', 'COMPLETE')
            ->where('personal_book_info.read', '=', 1)
            ->count();
    }

    public function getTotalAmountOfBooksBought()
    {
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->join('buy_info', 'personal_book_info.id', '=', 'buy_info.personal_book_info_id')
            ->where('wizard_step', '=', 'COMPLETE')
            ->count();
    }

    public function booksFromAuthor($authorId)
    {
        return Book::join('book_author', 'book_author.book_id', '=', 'book.id')
            ->where('book_author.author_id', '=', $authorId)
            ->get();
    }
}