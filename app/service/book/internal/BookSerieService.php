<?php

class BookSerieService
{

    /** @var  BookSerieRepository */
    private $bookSerieRepository;
    /** @var  BookRepository */
    private $bookRepository;

    /**
     * BookSerieService constructor.
     */
    public function __construct()
    {
        $this->bookSerieRepository = App::make('BookSerieRepository');
        $this->bookRepository = App::make('BookRepository');
    }

    public function findOrSave($name)
    {
        $serie = Serie::where(array('name' => $name))->first();

        if (is_null($serie)) {
            $serie = new Serie(array(
                'name' => $name
            ));
            $serie->save();
        }
        return $serie;
    }

    public function getSeries()
    {
        return Serie::all();
    }

    public function update(UpdateSerieRequest $updateSerieRequest){
        $serieToUpdate = $this->bookSerieRepository->find($updateSerieRequest->getId());
        Ensure::objectNotNull('Serie to update', $serieToUpdate, 'Serie to update does not exist');

        $serieByName = $this->bookSerieRepository->findByName($updateSerieRequest->getName());
        if($serieByName !== null && $serieByName->id != $updateSerieRequest->getId()){
            throw new ServiceException('A serie with this name already exists');
        }

        $serieToUpdate->name = $updateSerieRequest->getName();
        return $this->bookSerieRepository->save($serieToUpdate);
    }

    public function addBookToSerie($serieId, BookIdRequest $bookIdRequest)
    {
        $serieToUpdate = $this->bookSerieRepository->find($serieId);
        Ensure::objectNotNull('Serie to update', $serieToUpdate, 'Serie does not exist');
        $book = $this->bookRepository->find($bookIdRequest->getBookId());
        Ensure::objectNotNull('Book to update', $book, 'Book does not exist');

        $book->serie_id = $serieId;
        $this->bookRepository->save($book);
    }

    public function removeBookFromSerie($serieId, BookIdRequest $bookIdRequest)
    {
        $serieToUpdate = $this->bookSerieRepository->find($serieId);
        Ensure::objectNotNull('Serie to update', $serieToUpdate, 'Serie does not exist');
        $book = $this->bookRepository->find($bookIdRequest->getBookId());
        Ensure::objectNotNull('Book to update', $book, 'Book does not exist');
        if($book->serie_id != $serieId){
            throw new ServiceException('Trying to remove book from serie but book is not a part of the given serie');
        }

        $book->serie_id = null;
        $this->bookRepository->save($book);
    }

}