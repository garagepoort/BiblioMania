<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookSerieServiceUpdateTest extends TestCase
{
    /** @var  BookSerieService */
    private $bookSerieService;

    /** @var  BookSerieRepository $bookSerieRepository*/
    private $bookSerieRepository;

    /** @var  UpdateSerieRequestTestImpl */
    private $updateRequest;

    /** @var  Serie */
    private $serie;

    public function setUp()
    {
        parent::setUp();
        $this->updateRequest = new UpdateSerieRequestTestImpl();
        $this->bookSerieRepository = $this->mock('BookSerieRepository');
        $this->serie = $this->mockEloquent('Serie');
        $this->serie->shouldReceive('getAttribute')->with("id")->andReturn($this->updateRequest->getId());

        $this->bookSerieService = App::make('BookSerieService');
    }



    public function test_updatesCorrectly(){
        $this->updateRequest->setName('new name for serie');

        $this->bookSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn($this->serie);
        $this->bookSerieRepository->shouldReceive('findByName')->with($this->updateRequest->getName())->andReturn(null);
        $this->serie->shouldReceive('setAttribute')->with("name", $this->updateRequest->getName())->once();
        $this->bookSerieRepository->shouldReceive('save')->with($this->serie);

        $this->bookSerieService->update($this->updateRequest);
    }

    public function test_shouldNotThrowExceptionWhenSameSerieWithSameNameIsFound(){
        $this->bookSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn($this->serie);
        $this->bookSerieRepository->shouldReceive('findByName')->with($this->updateRequest->getName())->andReturn($this->serie);
        $this->serie->shouldReceive('setAttribute')->with("name", $this->updateRequest->getName())->once();

        $this->bookSerieRepository->shouldReceive('save')->with($this->serie);

        $this->bookSerieService->update($this->updateRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie to update does not exist
     */
    public function test_shouldThrowExceptionWhenSerieToUpdateDoesNotExists(){
        $this->bookSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn(null);

        $this->bookSerieService->update($this->updateRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage A serie with this name already exists
     */
    public function test_shouldThrowExceptionWhenOtherSerieWithSameNameAlreadyExists(){
        $otherSerie = $this->mockEloquent('Serie');
        $otherSerie->shouldReceive('getAttribute')->with("id")->andReturn(3984732);

        $this->bookSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn($this->serie);
        $this->bookSerieRepository->shouldReceive('findByName')->with($this->updateRequest->getName())->andReturn($otherSerie);

        $this->bookSerieService->update($this->updateRequest);
    }

}
