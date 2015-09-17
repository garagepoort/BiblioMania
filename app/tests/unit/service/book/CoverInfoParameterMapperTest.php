<?php

class CoverInfoParameterMapperTest extends TestCase {

    const IMAGE = "someImage";
    const COVER_TYPE = 'covertype';

    /** @var  CoverInfoParameterMapper */
    private $coverInfoParameterMapper;

    public function setUp(){
        parent::setUp();
        $this->imageServiceMock = $this->mock('ImageService');
        $this->coverInfoParameterMapper = App::make('CoverInfoParameterMapper');
    }

    public function testCreate_mapsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('book_type_of_cover', null)->andReturn(self::COVER_TYPE);

        $mockInput->shouldReceive('input')->with('coverInfoSelfUpload', null)->andReturn(true);
        $mockInput->shouldReceive('hasFile')->with('book_cover_image')->andReturn(true);
        $mockInput->shouldReceive('file')->with('book_cover_image')->andReturn(self::IMAGE);
        Input::swap($mockInput);

        $coverInfoParameters = $this->coverInfoParameterMapper->create();

        $this->assertEquals(self::IMAGE, $coverInfoParameters->getImage());
        $this->assertEquals(self::COVER_TYPE, $coverInfoParameters->getCoverType());
        $this->assertEquals(ImageSaveType::UPLOAD, $coverInfoParameters->getImageSaveType());
    }

    public function testWhenSelfUpload_getsImageFromInput(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('book_type_of_cover', null)->andReturn(self::COVER_TYPE);

        $mockInput->shouldReceive('input')->with('coverInfoSelfUpload', null)->andReturn(true);
        $mockInput->shouldReceive('hasFile')->with('book_cover_image')->andReturn(true);
        $mockInput->shouldReceive('file')->with('book_cover_image')->andReturn(self::IMAGE);
        Input::swap($mockInput);

        $coverInfoParameters = $this->coverInfoParameterMapper->create();

        $this->assertEquals(self::IMAGE, $coverInfoParameters->getImage());
        $this->assertEquals(ImageSaveType::UPLOAD, $coverInfoParameters->getImageSaveType());
    }

    public function testWhenNotSelfUpload_getsImageFromUrlIfUrlFilledIn(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('book_type_of_cover', null)->andReturn(self::COVER_TYPE);

        $mockInput->shouldReceive('input')->with('coverInfoSelfUpload', null)->andReturn(false);
        $mockInput->shouldReceive('input')->with('coverInfoUrl', null)->andReturn('someURL');
        Input::swap($mockInput);

        $coverInfoParameters = $this->coverInfoParameterMapper->create();

        $this->assertEquals('someURL', $coverInfoParameters->getImage());
        $this->assertEquals(ImageSaveType::URL, $coverInfoParameters->getImageSaveType());
    }
}
