<?php

class BookSerieService
{

    /** @var  BookSerieRepository */
    private $bookSerieRepository;

    /**
     * BookSerieService constructor.
     */
    public function __construct()
    {
        $this->bookSerieRepository = App::make('BookSerieRepository');
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

}