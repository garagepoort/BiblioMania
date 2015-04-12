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



//    public function findOrCreate($publisher_name){
//
//        $publisher = Publisher::where('name', '=', $publisher_name)
//            ->where("user_id", "=", Auth::user()->id)
//            ->first();
//
//        if (is_null($publisher)) {
//            $publisher = new Publisher(array(
//                'name' => $publisher_name
//            ));
//            $publisher->user_id = Auth::user()->id;
//        }
//        return $publisher;
//    }

    public function findOrCreate($name, $country){
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

        $publisher_country = $this->countryService->findOrCreate($country);

        if(!$publisher->countries->contains($publisher_country->id)){
            $publisher->countries()->attach($publisher_country);
        }

        return $publisher;

    }

    public function saveOrUpdate(Publisher $publisher)
    {
        $this->publisherRepository->save($publisher);
        return $publisher;
    }

    public function mergePublishers($publisher_id1, $publisher_id2){
        $publisher1 = Publisher::with('countries', 'first_print_infos', 'books')->find($publisher_id1);
        $publisher2 = Publisher::with('countries', 'first_print_infos', 'books')->find($publisher_id2);

        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');

        $logger->info("Merging publisher[$publisher1->id] and [$publisher2->id]");


        foreach($publisher2->countries as $country){
            $publisher1->countries()->sync([$country->id], false);
            $publisher1->save();
        }

        foreach($publisher2->books as $book){
            $book->publisher()->associate($publisher1);
            $book->save();
        }

        foreach($publisher2->first_print_infos as $firstPrint){
            $firstPrint->publisher()->associate($publisher1);
            $firstPrint->save();
        }

        $publisher2->countries()->sync([]);
        $publisher2->save();
        $publisher2->delete();
    }
}