<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class PublisherService
{
    /** @var  CountryService */
    private $countryService;
    /** @var  PublisherRepository */
    private $publisherRepository;

    function __construct()
    {
        $this->countryService = App::make('CountryService');
        $this->publisherRepository = App::make('PublisherRepository');
    }

    public function findOrCreate($name){
        $publisher = $this->publisherRepository->findByName($name);

        if (is_null($publisher)) {
            $publisher = new Publisher(array(
                'name' => $name
            ));
            $this->publisherRepository->save($publisher);
        }

        return $publisher;
    }

    public function updatePublisher($publisherId, $name){
        $publisher = $this->publisherRepository->find($publisherId);
        Ensure::objectNotNull('publisher', $publisher, 'translation.error.publisher.not.found');

        if($publisher != null){
            $publisher->name = $name;
            $publisher->save();
        }else{
            throw new ServiceException('Publisher to update not found');
        }
    }

    public function deletePublisher($publisherId){
        $publisher = $this->publisherRepository->find($publisherId, array('books', 'first_print_infos'));

        Ensure::objectNotNull('publisher', $publisher, 'translation.error.publisher.not.found');
        Ensure::arrayHasLength('publisher books', $publisher->books->all(), 0, 'translation.error.publisher.linked.to.books.can.not.be.deleted');
        Ensure::arrayHasLength('publisher first print', $publisher->first_print_infos->all(), 0, 'translation.error.publisher.linked.to.first.print.infos.can.not.be.deleted');

        $this->publisherRepository->delete($publisher);
    }

    public function getPublishers(){
        return Publisher::with('first_print_infos', 'books')->orderBy('name', 'asc')->get();
    }

    public function getPublisherSeries($publisherId){
        /** @var Publisher $publisher */
        $publisher = $this->publisherRepository->find($publisherId, array('series'));
        Ensure::objectNotNull('publisher', $publisher);
        return $publisher->series;
    }

    public function getPublisherBooks($publisherId){
        /** @var Publisher $publisher */
        $publisher = $this->publisherRepository->find($publisherId, array('books'));
        Ensure::objectNotNull('publisher', $publisher);
        return $publisher->books;
    }

    public function mergePublishers($publisher_id1, $publisher_id2){
        $publisher1 = Publisher::with('first_print_infos', 'books')->find($publisher_id1);
        $publisher2 = Publisher::with('first_print_infos', 'books')->find($publisher_id2);

        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');

        $logger->info("Merging publisher[$publisher1->id] and [$publisher2->id]");

        foreach($publisher2->books as $book){
            $book->publisher()->associate($publisher1);
            $book->save();
        }

        foreach($publisher2->first_print_infos as $firstPrint){
            $firstPrint->publisher()->associate($publisher1);
            $firstPrint->save();
        }

        $publisher2->save();
        $publisher2->delete();
    }

    public function getCountriesFromPublisher($id)
    {
        return $this->publisherRepository->getCountriesFromPublisher($id);
    }
}