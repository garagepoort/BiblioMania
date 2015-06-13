<?php

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
        $publisher = Publisher::where('name', '=', $name)
            ->where("user_id", "=", Auth::user()->id)
            ->first();

        if (is_null($publisher)) {
            $publisher = new Publisher(array(
                'name' => $name
            ));
            $publisher->user_id = Auth::user()->id;
        }
        $publisher->save();
        return $publisher;

    }

    public function saveOrUpdate(Publisher $publisher)
    {
        $this->publisherRepository->save($publisher);
        return $publisher;
    }

    public function updatePublisher($publisherId, $name){
        $publisher = Publisher::where('user_id' , '=', Auth::user()->id)
            ->where('id', '=', $publisherId)
            ->first();

        if($publisher != null){
            $publisher->name = $name;
            $publisher->save();
        }else{
            throw new ServiceException('Publisher to update not found');
        }
    }

    public function deletePublisher($publisherId){
        $publisher = Publisher::with('books', 'first_print_infos')
            ->where('user_id' , '=', Auth::user()->id)
            ->where('id', '=', $publisherId)
            ->first();

        if($publisher != null && count($publisher->books) == 0 && count($publisher->first_print_infos) == 0){
            $publisher->delete();
        }else{
            throw new ServiceException('Een uitgever met boeken mag niet verwijdert worden.');
        }
    }

    public function getPublishers(){
        return Publisher::with('first_print_infos', 'books')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')->get();
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