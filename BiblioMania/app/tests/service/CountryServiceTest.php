<?php

class CountryServiceTest extends TestCase {

    private $countryRepositoryMock;
    private $testedCountryService;

    const NEW_NAME = "NEW_NAME";

    public function setUp(){
        parent::setUp();
        $this->countryRepositoryMock = $this->mock('CountryRepository');
        $this->testedCountryService = new CountryService($this->countryRepositoryMock);
    }

    /**
     * @expectedException ServiceException
     */
    public function testEditCountryName_whenCountryDoesNotExist_throwError()
    {
        $this->countryRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->andReturn(null);

        $this->testedCountryService->editCountryName(1, self::NEW_NAME);
    }

    /**
     * @expectedException ServiceException
     */
    public function testEditCountryName_whenEmptyName_throwError()
    {
        $country = new Country();

        $this->countryRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($country);

        $this->testedCountryService->editCountryName(1, "");
    }

    public function testEditCountryName_savesCountryWithNewName()
    {
        $country = new Country();

        $this->countryRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->andReturn($country);

        $this->countryRepositoryMock
            ->shouldReceive('save')
            ->once()
            ->with($country);

        $this->testedCountryService->editCountryName(1, self::NEW_NAME);

        $this->assertEquals(self::NEW_NAME, $country->name);
    }

    /**
     * @expectedException ServiceException
     */
    public function testDeleteCountry_whenCountryDoesNotExist_throwError()
    {
        $this->countryRepositoryMock
            ->shouldReceive('findFull')
            ->once()
            ->andReturn(null);

        $this->testedCountryService->deleteCountry();
    }

    /**
     * @group ignore
     */
    public function testDeleteCountry_deletesCountry()
    {

        $country = new Country();

        $this->countryRepositoryMock
            ->shouldReceive('findFull')
            ->once()
            ->with(0)
            ->andReturn($country);

        $this->countryRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($country);

        $this->testedCountryService->deleteCountry();
    }
}
