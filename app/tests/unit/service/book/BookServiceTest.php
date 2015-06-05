<?php

class BookServiceTest extends TestCase {
    /** @var  BookService */
    private $bookService;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  ImageService */
    private $imageService;

    public function setUp(){
        parent::setUp();
        $this->imageService = $this->mock('ImageService');
        $this->bookRepository = $this->mock('BookRepository');
        $this->bookService = App::make('BookService');
        $user = new User(['name' => 'John', 'id' => 12]);

        $this->be($user);
    }

    public function test_createBook_whenShouldNotCreateImage_doesNotCreateImage(){
        $firstPrintInfoParameters = $this->mock("FirstPrintInfoParameters");
        $firstPrintInfo = $this->mock("FirstPrintInfo");
        $buyInfo = $this->mock("BuyInfoParameters");
        $authorInfo = $this->mock("AuthorInfoParameters");
        $extra = $this->mock("ExtraBookInfoParameters");
        $bookInfoParameters = $this->mock("BookInfoParameters");
        $personalBookinfo = $this->mock("PersonalBookInfoParameters");
        $publisher = $this->mockEloquent('Publisher');
        $country = $this->mockEloquent('Country');
        $author = $this->mockEloquent('Author');

        $coverInfo = new CoverInfoParameters('HARDCOVER', 'someImage', false);
        $bookCreationParameters = new BookCreationParameters($bookInfoParameters, $extra, $authorInfo, $buyInfo, null, $coverInfo, $firstPrintInfoParameters, $personalBookinfo);

        $createdBook = $this->bookService->createBook($bookCreationParameters, $publisher, $country, $firstPrintInfo, $author);


        $this->imageService
            ->shouldReceive('saveImage')
            ->never();

        $this->assertEquals('someImage', $createdBook->coverImage);
    }

    public function test_createBookWhenShouldCreateImage_createsImageCorrect(){
        $firstPrintInfoParameters = $this->mock("FirstPrintInfoParameters");
        $firstPrintInfo = $this->mock("FirstPrintInfo");
        $buyInfo = $this->mock("BuyInfoParameters");
        $authorInfo = $this->mock("AuthorInfoParameters");
        $extra = $this->mock("ExtraBookInfoParameters");
        $bookInfoParameters = $this->mock("BookInfoParameters");
        $personalBookinfo = $this->mock("PersonalBookInfoParameters");
        $publisher = $this->mockEloquent('Publisher');
        $country = $this->mockEloquent('Country');
        $author = $this->mockEloquent('Author');

        $coverInfo = new CoverInfoParameters('HARDCOVER', 'someImage', true);
        $bookCreationParameters = new BookCreationParameters($bookInfoParameters, $extra, $authorInfo, $buyInfo, null, $coverInfo, $firstPrintInfoParameters, $personalBookinfo);

        $this->imageService
            ->shouldReceive('saveImage')
            ->once()
            ->with('someImage', null)
            ->andReturn('imagePath');

        $createdBook = $this->bookService->createBook($bookCreationParameters, $publisher, $country, $firstPrintInfo, $author);

        $this->assertEquals('imagePath', $createdBook->coverImage);
    }

    public function test_createBookWhenImageNull_setsDefaultImage(){
        $firstPrintInfoParameters = $this->mock("FirstPrintInfoParameters");
        $firstPrintInfo = $this->mock("FirstPrintInfo");
        $buyInfo = $this->mock("BuyInfoParameters");
        $authorInfo = $this->mock("AuthorInfoParameters");
        $extra = $this->mock("ExtraBookInfoParameters");
        $bookInfoParameters = $this->mock("BookInfoParameters");
        $personalBookinfo = $this->mock("PersonalBookInfoParameters");
        $publisher = $this->mockEloquent('Publisher');
        $country = $this->mockEloquent('Country');
        $author = $this->mockEloquent('Author');

        $coverInfo = new CoverInfoParameters('HARDCOVER', null, true);
        $bookCreationParameters = new BookCreationParameters($bookInfoParameters, $extra, $authorInfo, $buyInfo, null, $coverInfo, $firstPrintInfoParameters, $personalBookinfo);

        $createdBook = $this->bookService->createBook($bookCreationParameters, $publisher, $country, $firstPrintInfo, $author);

        $this->imageService
            ->shouldReceive('saveImage')
            ->never();

        $this->assertEquals('images/questionCover.png', $createdBook->coverImage);
    }

    public function test_createBookWhenImageNull_andPreviousImageFilled_keepsPreviousImage(){
        $previousImage = "some/previous/image.png";
        $previousBook = new Book();
        $previousBook->coverImage = $previousImage;

        $firstPrintInfoParameters = $this->mock("FirstPrintInfoParameters");
        $firstPrintInfo = $this->mock("FirstPrintInfo");
        $buyInfo = $this->mock("BuyInfoParameters");
        $authorInfo = $this->mock("AuthorInfoParameters");
        $extra = $this->mock("ExtraBookInfoParameters");
        $bookInfoParameters = $this->mock("BookInfoParameters");
        $personalBookinfo = $this->mock("PersonalBookInfoParameters");
        $publisher = $this->mockEloquent('Publisher');
        $country = $this->mockEloquent('Country');
        $author = $this->mockEloquent('Author');

        $bookInfoParameters
            ->shouldReceive('getBookId')
            ->andReturn(1);

        $this->bookRepository
            ->shouldReceive('find')
            ->andReturn($previousBook);

        $coverInfo = new CoverInfoParameters('HARDCOVER', null, true);
        $bookCreationParameters = new BookCreationParameters($bookInfoParameters, $extra, $authorInfo, $buyInfo, null, $coverInfo, $firstPrintInfoParameters, $personalBookinfo);

        $createdBook = $this->bookService->createBook($bookCreationParameters, $publisher, $country, $firstPrintInfo, $author);

        $this->imageService
            ->shouldReceive('saveImage')
            ->never();

        $this->assertEquals($previousImage, $createdBook->coverImage);
    }
}
