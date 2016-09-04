<?php

class PublisherServiceFindOrCreateTest extends TestCase
{
    const NAME = "name";
    const USER_ID = 123;

    /** @var PublisherService $publisherService */
    private $publisherService;


    /** @var CountryService $countryService */
    private $countryService;
    /** @var PublisherRepository $publisherRepository */
    private $publisherRepository;
    /** @var Publisher $publisher */
    private $publisher;


    public function setUp(){
        parent::setUp();

        $this->publisherRepository = $this->mock('PublisherRepository');
        $this->countryService = $this->mock('CountryService');
        $this->publisher = $this->mockEloquent('Publisher');

        $this->publisherService = App::make('PublisherService');

    }

    public function test_createsPublisherWhenNotFound(){
        $this->publisherRepository->shouldReceive('findByUserAndName')->once()->with(self::USER_ID, self::NAME)->andReturn(null);

        $this->publisherRepository->shouldReceive('save')->once()
            ->with(Mockery::on(function($publisher){
                $this->assertEquals($publisher->name, self::NAME);
                $this->assertEquals($publisher->user_id, self::USER_ID);
                return true;
            }));

        $foundPublisher = $this->publisherService->findOrCreate(self::USER_ID, self::NAME);

        $this->assertEquals($foundPublisher->user_id, self::USER_ID);
        $this->assertEquals($foundPublisher->name, self::NAME);
    }

    public function test_retrievesPublisherWhenFound(){
        $this->publisherRepository->shouldReceive('findByUserAndName')->once()->with(self::USER_ID, self::NAME)->andReturn($this->publisher);
        $this->publisherRepository->shouldReceive('save')->never();

        $foundPublisher = $this->publisherService->findOrCreate(self::USER_ID, self::NAME);

        $this->assertEquals($foundPublisher, $this->publisher);
    }
}
