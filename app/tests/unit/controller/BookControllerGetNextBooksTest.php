<?php

class BookControllerGetNextBooksTest extends TestCase
{
    const ORDER_BY = "order_by";
    const BOOK_ID = "book id";

    /** @var  BookService */
    private $bookService;

    private $filteredResults;

    public function setUp(){
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->filteredResults = $this->mock('Illuminate\Pagination\Paginator');
    }

    public function test_getsFilteredBooksFromService(){
        $this->bookService->shouldReceive('getFilteredBooks')->with(self::BOOK_ID, any("BookFilterValues"), self::ORDER_BY)
                ->once()
                ->andReturn($this->filteredResults);

        $this->filteredResults->shouldReceive('getItems')->andReturn(array(
            $this->createBook(123,11,21,31, "coverImage1", true, "old tag"),
            $this->createBook(231,12,22,32, "coverImage2", true, "other old tag"),
            $this->createBook(321,13,23,33, "coverImage3", true, ""),
        ));

        $this->filteredResults->shouldReceive('getTotal')->andReturn("3");
        $this->filteredResults->shouldReceive('getCurrentPage')->andReturn("1");
        $this->filteredResults->shouldReceive('getLastPage')->andReturn("100");

        $parameters = array(
            'book_id'=>self::BOOK_ID,
            'order_by'=>self::ORDER_BY,
        );

        $response = $this->action('GET', 'BookController@getNextBooks', null, $parameters);

        $this->assertEquals($response->original, array(
            "total"=>"3",
            "last_page"=>"100",
            "current_page"=>"1",
            "data"=>array(
                array("id"=>"123", "imageHeight"=>"21", "imageWidth"=>"11","spritePointer"=>"31", "coverImage"=>"coverImage1", "useSpriteImage"=>true, "hasWarnings" =>true),
                array("id"=>"231", "imageHeight"=>"22", "imageWidth"=>"12","spritePointer"=>"32", "coverImage"=>"coverImage2", "useSpriteImage"=>true, "hasWarnings" =>true),
                array("id"=>"321", "imageHeight"=>"23", "imageWidth"=>"13","spritePointer"=>"33", "coverImage"=>"coverImage3", "useSpriteImage"=>true, "hasWarnings" =>false)
            )
        ));
    }

    private function createBook($id, $imageWidth, $imageHeight, $spritePointer, $coverImage, $useSpriteImage, $old_tags){
        $book = $this->createFakeBook();
        $book->id = $id;
        $book->imageWidth = $imageWidth;
        $book->imageHeight = $imageHeight;
        $book->spritePointer = $spritePointer;
        $book->useSpriteImage = $useSpriteImage;
        $book->coverImage = $coverImage;
        $book->old_tags = $old_tags;
        return $book;
    }
}
