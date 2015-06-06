<?php

class FileToCoverInfoParametersMapperTest extends TestCase {

    /** @var  FileToCoverInfoParametersMapper */
    private $fileToCoverInfoParametersMapper;

    public function setUp(){
        parent::setUp();
        $this->fileToCoverInfoParametersMapper = App::make('FileToCoverInfoParametersMapper');

        $user = new User(['username' => 'John']);
        $this->be($user);
    }

    public function test_map_worksCorrect(){
        $line_values = [50];

        $line_values[LineMapping::CoverInfoImagePath] = "book\\some\\image";
        $line_values[LineMapping::CoverInfoType] = "someType";

        /** @var CoverInfoParameters $parameters */
        $parameters = $this->fileToCoverInfoParametersMapper->map($line_values);

        $this->assertEquals("bookImages/John/image", $parameters->getImage());
        $this->assertEquals("someType", $parameters->getCoverType());
        $this->assertEquals(true, $parameters->getImageSaveType());
    }

    public function test_mapWithImageEmpty_worksCorrect(){
        $line_values = [50];

        $line_values[LineMapping::CoverInfoImagePath] = "";
        $line_values[LineMapping::CoverInfoType] = "someType";

        /** @var CoverInfoParameters $parameters */
        $parameters = $this->fileToCoverInfoParametersMapper->map($line_values);

        $this->assertEquals(null, $parameters->getImage());
        $this->assertEquals("someType", $parameters->getCoverType());
        $this->assertEquals(true, $parameters->getImageSaveType());
    }
}
