<?php

class BookDTOMapperTest extends \TestCase {
    /** @var  BookDTOMapper */
    private $bookDTOMapper;

    public function setUp(){
        parent::setUp();
        $this->bookDTOMapper = App::make('BookDTOMapper');
    }

    public function testMap_worksCorrect(){
        $book = new Book();
        $book->id = 12;
        $book->image = "someImage";
        $book->title = "someTitle";
        /** @var BookDTO $bookDTO */
        $bookDTO = $this->bookDTOMapper->mapToBookDTO($book);

        $this->assertEquals($book->id, $bookDTO->getId());
        $this->assertEquals($book->image, $bookDTO->getImage());
        $this->assertEquals($book->title, $bookDTO->getTitle());
    }

    public function testMapBooks_worksCorrect(){
        $book = new Book();
        $book->id = 12;
        $book->image = "someImage";
        $book->title = "someTitle";

        /** @var BookDTO $bookDTO */
        $bookDTOs = $this->bookDTOMapper->mapBooksToBookDTO(array($book));

        $bookDTO = $bookDTOs[0];
        $this->assertEquals($book->id, $bookDTO->getId());
        $this->assertEquals($book->image, $bookDTO->getImage());
        $this->assertEquals($book->title, $bookDTO->getTitle());
    }
}
