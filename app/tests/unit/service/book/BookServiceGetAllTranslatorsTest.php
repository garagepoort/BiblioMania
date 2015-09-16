<?php

class BookServiceGetAllTranslatorsTest extends TestCase
{
    /** @var BookService */
    private $bookService;
    /** @var BookRepository */
    private $bookRepository;

    private $translators = array("translator1", "translator2");


    public function setUp()
    {
        parent::setUp();
        $this->bookRepository = $this->mock('BookRepository');
        $this->bookService = App::make('BookService');
    }

    public function test_shouldDelegateToRepository(){
        $this->bookRepository->shouldReceive('getAllTranslators')
            ->once()
            ->andReturn($this->translators);

        $result = $this->bookService->getAllTranslators();

        $this->assertEquals($result, $this->translators);
    }

}
