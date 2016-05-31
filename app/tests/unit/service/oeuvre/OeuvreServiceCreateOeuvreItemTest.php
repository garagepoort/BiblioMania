<?php

class OeuvreServiceCreateOeuvreItemTest extends TestCase
{
    const AUTHOR_ID = 123;
    const PUBLICATION_YEAR = 1991;
    const TITLE = 'title';

    /** @var OeuvreService $oeuvreService */
    private $oeuvreService;
    /** @var AuthorRepository $authorRepository */
    private $authorRepository;
    /** @var OeuvreItemRepository $oeuvreItemRepository */
    private $oeuvreItemRepository;
    /** @var Author $author */
    private $author;
    /** @var CreateOeuvreItemRequestTestImpl $createOeuvreItemRequestTestImpl */
    private $createOeuvreItemRequestTestImpl;

    public function setUp(){
        parent::setUp();
        $this->createOeuvreItemRequestTestImpl = new CreateOeuvreItemRequestTestImpl();
        $this->createOeuvreItemRequestTestImpl->setAuthorId(self::AUTHOR_ID);
        $this->createOeuvreItemRequestTestImpl->setPublicationYear(self::PUBLICATION_YEAR);
        $this->createOeuvreItemRequestTestImpl->setTitle(self::TITLE);

        $this->oeuvreItemRepository = $this->mock('OeuvreItemRepository');
        $this->authorRepository = $this->mock('AuthorRepository');
        $this->author = $this->mockEloquent('Author');

        $this->oeuvreService = App::make('OeuvreService');
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Author not found
     */
    public function test_throwsExceptionWhenAuthorNotFound(){
        $this->authorRepository->shouldReceive('find')->with(self::AUTHOR_ID)->andReturn(null);

        $this->oeuvreService->createOeuvreItem($this->createOeuvreItemRequestTestImpl);
    }

    public function test_createsCorrectly(){
        $this->authorRepository->shouldReceive('find')->with(self::AUTHOR_ID)->andReturn($this->author);
        $this->oeuvreItemRepository->shouldReceive('save')->once()->with(Mockery::on(function(BookFromAuthor $oeuvreItem){
            $this->assertEquals($oeuvreItem->author_id, self::AUTHOR_ID);
            $this->assertEquals($oeuvreItem->title, self::TITLE);
            $this->assertEquals($oeuvreItem->publication_year, self::PUBLICATION_YEAR);
            return true;
        }));

        $this->oeuvreService->createOeuvreItem($this->createOeuvreItemRequestTestImpl);
    }

}