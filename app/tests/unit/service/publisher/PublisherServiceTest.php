<?php

class PublisherServiceTest extends TestCase {

    /** @var  PublisherService */
    private $publisherService;
    /** @var  PublisherRepository */
    private $publisherRepository;

    public function setUp(){
        parent::setUp();
        $this->publisherRepository = $this->mock("PublisherRepository");
        $this->publisherService = App::make('PublisherService');
    }

    public function test_saveOrUpdate_callsRepository(){
        $publisher = new Publisher();

        $this->publisherRepository->shouldReceive("save")->once()->with($publisher);

        $this->publisherService->saveOrUpdate($publisher);
    }
}
