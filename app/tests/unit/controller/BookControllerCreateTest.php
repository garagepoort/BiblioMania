<?php

class BookControllerCreateTest extends TestCase
{
    const TITLE = 'title';
    const SUBTITLE = 'subtitle';
    const GENRE = 'genre';
    const PUBLISHER = 'publisher';
    const COUNTRY = 'country';
    const LANGUAGE = 'language';
    const PREFERRED_AUTHOR_ID = 213;
    const PUBLICATION_DATE_DAY = 31;
    const PUBLICATION_DATE_MONTH = 12;
    const PUBLICATION_DATE_YEAR = 2015;
    const TRANSLATOR = 'translator';
    const _PRINT = 12;
    const PAGES = 1231;
    const IMAGE_URL = 'imageUrl';
    const ISBN = '2301203421321';
    const SERIE = 'serie';
    const PUBLISHER_SERIE = 'publisherSerie';
    const TAG_1 = 'tag1';
    const TAG_2 = 'tag2';
    const TAG_3 = 'tag3';

    /** @var  BookService */
    private $bookService;

    public function setUp()
    {
        parent::setUp();
        $this->bookService = $this->mock('BookService');
    }

    public function test_shouldCallJsonMappingAndService(){
        $postData = array(
            'title' => self::TITLE,
            'isbn' => self::ISBN,
            'subtitle' => self::SUBTITLE,
            'genre' => self::GENRE,
            'publisher' => self::PUBLISHER,
            'country' => self::COUNTRY,
            'language' => self::LANGUAGE,
            'translator' => self::TRANSLATOR,
            'print' => self::_PRINT,
            'pages' => self::PAGES,
            'imagUrl' => self::IMAGE_URL,
            'serie' => self::SERIE,
            'publisherSerie' => self::PUBLISHER_SERIE,
            'preferredAuthorId' => self::PREFERRED_AUTHOR_ID,
            'publicationDate' => array('day'=> self::PUBLICATION_DATE_DAY, 'month'=> self::PUBLICATION_DATE_MONTH, 'year'=> self::PUBLICATION_DATE_YEAR),
            'tags' => array(
                array('text'=> self::TAG_1),
                array('text'=> self::TAG_2),
                array('text'=> self::TAG_3)
            )
        );

        $this->bookService->shouldReceive('create')->once()->with(Mockery::on(function(BaseBookRequest $baseBookRequest){
            $this->assertEquals(self::TITLE, $baseBookRequest->getTitle());
            $this->assertEquals(self::ISBN, $baseBookRequest->getIsbn());
            $this->assertEquals(self::SUBTITLE, $baseBookRequest->getSubtitle());
            $this->assertEquals(self::PREFERRED_AUTHOR_ID, $baseBookRequest->getPreferredAuthorId());
            $this->assertEquals(self::PUBLISHER, $baseBookRequest->getPublisher());
            $this->assertEquals(self::COUNTRY, $baseBookRequest->getCountry());
            $this->assertEquals(self::LANGUAGE, $baseBookRequest->getLanguage());
            $this->assertEquals(self::GENRE, $baseBookRequest->getGenre());
            $this->assertEquals(self::TRANSLATOR, $baseBookRequest->getTranslator());
            $this->assertEquals(self::_PRINT, $baseBookRequest->getPrint());
            $this->assertEquals(self::PAGES, $baseBookRequest->getPages());
            $this->assertEquals(self::SERIE, $baseBookRequest->getSerie());
            $this->assertEquals(self::PUBLISHER_SERIE, $baseBookRequest->getPublisherSerie());

            $publicationDate = $baseBookRequest->getPublicationDate();
            $this->assertEquals(self::PUBLICATION_DATE_DAY, $publicationDate->getDay());
            $this->assertEquals(self::PUBLICATION_DATE_MONTH, $publicationDate->getMonth());
            $this->assertEquals(self::PUBLICATION_DATE_YEAR, $publicationDate->getYear());

            $tags = $baseBookRequest->getTags();
            $this->assertEquals(self::TAG_1, $tags[0]->getText());
            $this->assertEquals(self::TAG_2, $tags[1]->getText());
            $this->assertEquals(self::TAG_3, $tags[2]->getText());

            return true;
        }));

        $response = $this->action('POST', 'BookController@createBook', array(), $postData);

        $this->assertResponseOk();
    }
}