<?php

class CoverInfoParameterMapperTest extends TestCase {

    const IMAGE = "someImage";
    const COVER_TYPE = 'covertype';

    /** @var  CoverInfoParameterMapper */
    private $coverInfoParameterMapper;
    /** @var  ImageService */
    private $imageServiceMock;

    public function setUp(){
        parent::setUp();
        $this->imageServiceMock = $this->mock('ImageService');
        $this->coverInfoParameterMapper = App::make('CoverInfoParameterMapper');
    }

    public function testCreate_mapsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('book_type_of_cover', null)->andReturn(self::COVER_TYPE);

        $mockInput->shouldReceive('input')->with('coverInfoSelfUpload', null)->andReturn(true);
        $mockInput->shouldReceive('file')->andReturn(self::IMAGE);
        Input::swap($mockInput);

        $coverInfoParameters = $this->coverInfoParameterMapper->create();

        $this->assertEquals(self::IMAGE, $coverInfoParameters->getImage());
        $this->assertEquals(self::COVER_TYPE, $coverInfoParameters->getCoverType());
    }

    public function testWhenSelfUpload_getsImageFromInput(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('book_type_of_cover', null)->andReturn(self::COVER_TYPE);

        $mockInput->shouldReceive('input')->with('coverInfoSelfUpload', null)->andReturn(true);
        $mockInput->shouldReceive('file')->andReturn(self::IMAGE);
        Input::swap($mockInput);

        $coverInfoParameters = $this->coverInfoParameterMapper->create();

        $this->assertEquals(self::IMAGE, $coverInfoParameters->getImage());
    }

    public function testWhenNotSelfUpload_getsImageFromUrlIfUrlFilledIn(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('book_type_of_cover', null)->andReturn(self::COVER_TYPE);

        $mockInput->shouldReceive('input')->with('coverInfoSelfUpload', null)->andReturn(false);
        $mockInput->shouldReceive('input')->with('coverInfoUrl', null)->andReturn('someURL');
        $this->imageServiceMock->shouldReceive('getImage')->with('someURL')->once()->andReturn('myImage');
        Input::swap($mockInput);

        $coverInfoParameters = $this->coverInfoParameterMapper->create();

        $this->assertEquals('myImage', $coverInfoParameters->getImage());
    }
}
