<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class CountryServiceTest extends TestCase {
    /** @var CountryRepository $countryRepositoryMock */
    private $countryRepositoryMock;
    /** @var CountryService $testedCountryService */
    private $testedCountryService;

    const NEW_NAME = "NEW_NAME";
    const COUNTRY_ID = 123;

    public function setUp(){
        parent::setUp();
        $this->countryRepositoryMock = $this->mock('CountryRepository');
        $this->testedCountryService = new CountryService($this->countryRepositoryMock);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     */
    public function testEditCountryName_whenCountryDoesNotExist_throwError()
    {
        $this->countryRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with(self::COUNTRY_ID)
            ->andReturn(null);

        $this->testedCountryService->editCountryName(self::COUNTRY_ID, self::NEW_NAME);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     */
    public function testEditCountryName_whenEmptyName_throwError()
    {
        $country = new Country();

        $this->countryRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with(self::COUNTRY_ID)
            ->andReturn($country);

        $this->testedCountryService->editCountryName(self::COUNTRY_ID, "");
    }

    public function testEditCountryName_savesCountryWithNewName()
    {
        $country = new Country();

        $this->countryRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with(self::COUNTRY_ID)
            ->andReturn($country);

        $this->countryRepositoryMock
            ->shouldReceive('save')
            ->once()
            ->with($country);

        $this->testedCountryService->editCountryName(self::COUNTRY_ID, self::NEW_NAME);

        $this->assertEquals(self::NEW_NAME, $country->name);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     */
    public function testDeleteCountry_whenCountryDoesNotExist_throwError()
    {
        $this->countryRepositoryMock
            ->shouldReceive('findFull')
            ->once()
            ->with(self::COUNTRY_ID)
            ->andReturn(null);

        $this->testedCountryService->deleteCountry(self::COUNTRY_ID);
    }

    public function testDeleteCountry_deletesCountry()
    {

        $country = new Country();
        $country->books = array();
        $country->authors = array();
        $country->cities = array();
        $country->publishers = array();
        $country->first_print_infos = array();

        $this->countryRepositoryMock
            ->shouldReceive('findFull')
            ->once()
            ->with(self::COUNTRY_ID)
            ->andReturn($country);

        $this->countryRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($country);

        $this->testedCountryService->deleteCountry(self::COUNTRY_ID);
    }
}
