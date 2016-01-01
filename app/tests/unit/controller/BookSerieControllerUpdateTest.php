<?php

class BookSerieControllerUpdateTest extends TestCase
{
    const SERIE_ID = 21312;
    const NAME = 'een serie';

    /** @var  BookSerieService */
    private $bookSerieService;

    public function setUp()
    {
        parent::setUp();
        $this->bookSerieService = $this->mock('BookSerieService');
    }

    public function test_shouldCallJsonMappingAndService(){
        $data = array(
            'id' => self::SERIE_ID,
            'name' => self::NAME
        );

        $this->bookSerieService->shouldReceive('update')->once()->with(Mockery::on(function(UpdateSerieRequest $updateSerieRequest){
            $this->assertEquals(self::SERIE_ID, $updateSerieRequest->getId());
            $this->assertEquals(self::NAME, $updateSerieRequest->getName());
            return true;
        }));

        $response = $this->action('PUT', 'SerieController@updateSerie', array(), $data);

        $this->assertResponseOk();
    }
}