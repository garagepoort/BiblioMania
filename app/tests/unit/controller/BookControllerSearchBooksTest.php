<?php

class BookControllerSearchBooksTest extends TestCase
{
    const ORDER_BY = "order_by";
    const BOOK_ID = "book id";

    /** @var  BookService */
    private $bookService;

    /** @var  FilteredBooksResult $filteredBooksResult */
    private $filteredBooksResult;
    private $paginatedItems;

    public function setUp(){
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->paginatedItems = $this->mock('Illuminate\Pagination\Paginator');
        $this->filteredBooksResult = $this->mock('FilteredBooksResult');
    }

    public function test_getsFilteredBooksFromService(){
        $this->bookService->shouldReceive('getFilteredBooks')->with(self::BOOK_ID, any("BookSearchValues"), self::ORDER_BY)
                ->once()
                ->andReturn($this->filteredBooksResult);

        $this->filteredBooksResult->shouldReceive('getPaginatedItems')->andReturn($this->paginatedItems);
        $this->filteredBooksResult->shouldReceive('getTotalAmountOfBooks')->andReturn("3");
        $this->filteredBooksResult->shouldReceive('getTotalAmountOfBooksOwned')->andReturn("2");
        $this->filteredBooksResult->shouldReceive('getTotalValue')->andReturn("300");

        $this->paginatedItems->shouldReceive('getItems')->andReturn(array(
            $this->createBook(123,11,21,31, "coverImage1", true, "old tag"),
            $this->createBook(231,12,22,32, "coverImage2", true, "other old tag"),
            $this->createBook(321,13,23,33, "coverImage3", true, ""),
        ));

        $this->paginatedItems->shouldReceive('getTotal')->andReturn("3");
        $this->paginatedItems->shouldReceive('getCurrentPage')->andReturn("1");
        $this->paginatedItems->shouldReceive('getLastPage')->andReturn("100");


        $parameters = array(
            'book_id'=>self::BOOK_ID,
            'order_by'=>self::ORDER_BY,
        );

        $response = $this->action('GET', 'BookController@searchBooks', null, $parameters);

        $this->assertEquals($response->original, array(
            "total"=>"3",
            "last_page"=>"100",
            "current_page"=>"1",
            "data"=>array(
                array("id"=>"123", "imageHeight"=>"21", "imageWidth"=>"11","spritePointer"=>"31", "coverImage"=>"coverImage1", "useSpriteImage"=>true, "hasWarnings" =>true, "read"=>true),
                array("id"=>"231", "imageHeight"=>"22", "imageWidth"=>"12","spritePointer"=>"32", "coverImage"=>"coverImage2", "useSpriteImage"=>true, "hasWarnings" =>true, "read"=>true),
                array("id"=>"321", "imageHeight"=>"23", "imageWidth"=>"13","spritePointer"=>"33", "coverImage"=>"coverImage3", "useSpriteImage"=>true, "hasWarnings" =>false, "read"=>true)
            ),
            "library_information" => array(
                "total_amount_books" => "3",
                "total_amount_books_owned" => "2",
                "total_value" => "300"
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
        $personalBookInfo = new PersonalBookInfo();
        $book->personal_book_info = $personalBookInfo;
        $personalBookInfo->read = true;
        return $book;
    }
}
