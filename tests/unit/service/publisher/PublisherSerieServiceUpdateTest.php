<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class PublisherSerieServiceUpdateTest extends TestCase
{
    /** @var  PublisherSerieService */
    private $publisherSerieService;

    /** @var  PublisherSerieRepository $publisherSerieRepository*/
    private $publisherSerieRepository;

    /** @var  UpdateSerieRequestTestImpl */
    private $updateRequest;

    /** @var  PublisherSerie */
    private $serie;

    public function setUp()
    {
        parent::setUp();
        $this->updateRequest = new UpdateSerieRequestTestImpl();
        $this->publisherSerieRepository = $this->mock('PublisherSerieRepository');
        $this->serie = $this->mockEloquent('PublisherSerie');
        $this->serie->shouldReceive('getAttribute')->with("id")->andReturn($this->updateRequest->getId());

        $this->publisherSerieService = App::make('PublisherSerieService');
    }



    public function test_updatesCorrectly(){
        $this->updateRequest->setName('new name for serie');

        $this->publisherSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn($this->serie);
        $this->publisherSerieRepository->shouldReceive('findByName')->with($this->updateRequest->getName())->andReturn(null);
        $this->serie->shouldReceive('setAttribute')->with("name", $this->updateRequest->getName());
        $this->publisherSerieRepository->shouldReceive('save')->with($this->serie);

        $this->publisherSerieService->update($this->updateRequest);
    }

    public function test_shouldNotThrowExceptionWhenSameSerieWithSameNameIsFound(){
        $this->publisherSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn($this->serie);
        $this->publisherSerieRepository->shouldReceive('findByName')->with($this->updateRequest->getName())->andReturn($this->serie);
        $this->serie->shouldReceive('setAttribute')->with("name", $this->updateRequest->getName());

        $this->publisherSerieRepository->shouldReceive('save')->with($this->serie);

        $this->publisherSerieService->update($this->updateRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie to update does not exist
     */
    public function test_shouldThrowExceptionWhenSerieToUpdateDoesNotExists(){
        $this->publisherSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn(null);

        $this->publisherSerieService->update($this->updateRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage A serie with this name already exists
     */
    public function test_shouldThrowExceptionWhenOtherSerieWithSameNameAlreadyExists(){
        $otherSerie = $this->mockEloquent('Serie');
        $otherSerie->shouldReceive('getAttribute')->with("id")->andReturn(3984732);

        $this->publisherSerieRepository->shouldReceive('find')->with($this->updateRequest->getId())->andReturn($this->serie);
        $this->publisherSerieRepository->shouldReceive('findByName')->with($this->updateRequest->getName())->andReturn($otherSerie);

        $this->publisherSerieService->update($this->updateRequest);
    }

}
