<?php

class OeuvreServiceTest extends TestCase {

    /** @var  OeuvreService */
    private $oeuvreService;
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;

    public function setUp(){
        parent::setUp();
        $this->bookFromAuthorRepository = $this->mock("BookFromAuthorRepository");
        $this->oeuvreService = App::make("OeuvreService");
    }

}
