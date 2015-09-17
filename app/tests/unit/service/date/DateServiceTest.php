<?php

class DateServiceTest extends TestCase
{

    /** @var DateService */
    private $dateService;

    public function setUp()
    {
        parent::setUp();
        $this->dateService = App::make("DateService");
    }

    public function testCopyDate_copiesValuesCorrect()
    {
        $date = new Date();
        $dateToCopy = new Date();

        $date->day = 1;
        $date->month = 8;
        $date->year = 2014;

        $dateToCopy->day = 6;
        $dateToCopy->month = 2;
        $dateToCopy->year = 1991;

        $this->dateService->copyDateValues($date, $dateToCopy);

        $this->assertEquals(6, $date->day);
        $this->assertEquals(2, $date->month);
        $this->assertEquals(1991, $date->year);
    }
}
