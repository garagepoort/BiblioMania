<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class PublisherSerieService
{
    /** @var  PublisherSerieRepository */
    private $publisherSerieRepository;
    /** @var  BookRepository */
    private $bookRepository;

    public function __construct()
    {
        $this->publisherSerieRepository = App::make('PublisherSerieRepository');
        $this->bookRepository = App::make('BookRepository');
    }

    public function findOrSave($name, $publisher_id)
    {

        $serie = PublisherSerie::where(array('name' => $name))
            ->where('publisher_id', '=', $publisher_id)
            ->first();

        if (is_null($serie)) {
            $serie = new PublisherSerie(array(
                'name' => $name,
                'publisher_id' => $publisher_id
            ));
            $serie->save();
        }
        return $serie;
    }

    public function getPublisherSeries()
    {
        return PublisherSerie::all();
    }

    public function update(UpdateSerieRequest $updateSerieRequest){
        $serieToUpdate = $this->publisherSerieRepository->find($updateSerieRequest->getId());
        Ensure::objectNotNull('Serie to update', $serieToUpdate, 'Serie to update does not exist');

        $serieByName = $this->publisherSerieRepository->findByName($updateSerieRequest->getName());
        if($serieByName !== null && $serieByName->id != $updateSerieRequest->getId()){
            throw new ServiceException('A serie with this name already exists');
        }

        $serieToUpdate->name = $updateSerieRequest->getName();
        return $this->publisherSerieRepository->save($serieToUpdate);
    }

    public function addBookToSerie($serieId, BookIdRequest $bookIdRequest)
    {
        $serieToUpdate = $this->publisherSerieRepository->find($serieId);
        Ensure::objectNotNull('Serie to update', $serieToUpdate, 'Serie does not exist');
        $book = $this->bookRepository->find($bookIdRequest->getBookId());
        Ensure::objectNotNull('Book to update', $book, 'Book does not exist');

        $book->publisher_serie_id = $serieId;
        $this->bookRepository->save($book);
    }

    public function removeBookFromSerie($serieId, BookIdRequest $bookIdRequest)
    {
        $serieToUpdate = $this->publisherSerieRepository->find($serieId);
        Ensure::objectNotNull('Serie to update', $serieToUpdate, 'Serie does not exist');
        $book = $this->bookRepository->find($bookIdRequest->getBookId());
        Ensure::objectNotNull('Book to update', $book, 'Book does not exist');
        if($book->publisher_serie_id != $serieId){
            throw new ServiceException('Trying to remove book from serie but book is not a part of the given serie');
        }

        $book->publisher_serie_id = null;
        $this->bookRepository->save($book);
    }

    public function deleteSerie($id)
    {
        $serieToDelete = $this->publisherSerieRepository->find($id);
        Ensure::objectNotNull('Serie to update', $serieToDelete, 'Serie does not exist');
        Ensure::arrayHasLength('books from serie', $serieToDelete->books->all(), 0, 'Serie can not be deleted when it is not empty');

        $this->publisherSerieRepository->delete($serieToDelete);
    }
}