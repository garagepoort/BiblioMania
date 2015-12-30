<?php

class BookServiceTest extends TestCase {
    const BOOK_ID = 123;

    /** @var  BookService */
    private $bookService;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  ImageService */
    private $imageService;
    /** @var Book $book */
    private $book;

    private $WITH_ARRAY = array('bla', 'oim');

    public function setUp(){
        parent::setUp();
        $this->imageService = $this->mock('ImageService');
        $this->bookRepository = $this->mock('BookRepository');
        $this->bookService = App::make('BookService');
        $user = new User(['name' => 'John', 'id' => 12]);
        $this->book = $this->mockEloquent('Book');

        $this->be($user);
    }

    public function test_findBook_callsRepository(){

        $this->bookRepository
            ->shouldReceive('find')
            ->once()
            ->with(self::BOOK_ID, $this->WITH_ARRAY)
            ->andReturn($this->book);

        $foundBook = $this->bookService->find(self::BOOK_ID, $this->WITH_ARRAY);

        $this->assertEquals($this->book, $foundBook);
    }
}
