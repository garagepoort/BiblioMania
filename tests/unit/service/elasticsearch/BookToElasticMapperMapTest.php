<?php

use Illuminate\Database\Eloquent\Collection;

class BookToElasticMapperMapTest extends TestCase
{
	const BOOK_ID = 123;
	const ISBN = "isbn";
	const TITLE = "title";
	const SUBTITLE = "subtitle";
	const PUBLISHER_COUNTRY_ID = 321;
	const PUBLISHER_ID = 543;
	const LANGUAGE_ID = 345;
	const AUTHOR_NAME = "authorName";
	const AUTHOR_FIRST_NAME = "authorFirstName";
	const GENRE_ID = 98;
	const CURRENCY = "EUR";
	const AMOUNT = 45678;

	/** @var BookToElasticMapper */
	private $bookToElasticMapper;

	/** @var  AuthorToElasticMapper $authorToElasticMapper */
	private $authorToElasticMapper;
	/** @var  PersonalBookInfoToElasticMapper $personalBookInfoToElasticMapper */
	private $personalBookInfoToElasticMapper;
	/** @var  TagToElasticMapper $tagToElasticMapper */
	private $tagToElasticMapper;
	/** @var Book $book */
	private $book;
	/** @var  Collection $authors */
	private $authors;
	/** @var  Collection $personalBookInfos */
	private $personalBookInfos;
	/** @var  Collection $wishLists */
	private $wishLists;
	/** @var  Collection $tags */
	private $tags;
	/** @var Author $author */
	private $author;


	public function setUp(){
	    parent::setUp();

		$this->authorToElasticMapper = $this->mock('AuthorToElasticMapper');
		$this->personalBookInfoToElasticMapper = $this->mock('PersonalBookInfoToElasticMapper');
		$this->tagToElasticMapper = $this->mock('TagToElasticMapper');

		$this->authors = $this->mockEloquentCollection();
		$this->personalBookInfos = $this->mockEloquentCollection();
		$this->wishLists = $this->mockEloquentCollection();
		$this->tags = $this->mockEloquentCollection();

		$this->authors->shouldReceive('all')->andReturn(array())->byDefault();
		$this->personalBookInfos->shouldReceive('all')->andReturn(array())->byDefault();
		$this->wishLists->shouldReceive('all')->andReturn(array())->byDefault();
		$this->tags->shouldReceive('all')->andReturn(array())->byDefault();

		$this->author = $this->mockEloquent('Author');
		$this->author->shouldReceive('getAttribute')->with('name')->andReturn(self::AUTHOR_NAME);
		$this->author->shouldReceive('getAttribute')->with('firstname')->andReturn(self::AUTHOR_FIRST_NAME);

		$this->book = $this->mockEloquent(Book::class);
		$this->book->shouldReceive('mainAuthor')->with()->andReturn($this->author);
		$this->book->shouldReceive('getAttribute')->with('id')->andReturn(self::BOOK_ID);
		$this->book->shouldReceive('getAttribute')->with('ISBN')->andReturn(self::ISBN);
		$this->book->shouldReceive('getAttribute')->with('title')->andReturn(self::TITLE);
		$this->book->shouldReceive('getAttribute')->with('subtitle')->andReturn(self::SUBTITLE);
		$this->book->shouldReceive('getAttribute')->with('publisher_country_id')->andReturn(self::PUBLISHER_COUNTRY_ID);
		$this->book->shouldReceive('getAttribute')->with('publisher_id')->andReturn(self::PUBLISHER_ID);
		$this->book->shouldReceive('getAttribute')->with('language_id')->andReturn(self::LANGUAGE_ID);
		$this->book->shouldReceive('getAttribute')->with('genre_id')->andReturn(self::GENRE_ID);
		$this->book->shouldReceive('getAttribute')->with('retail_price')->andReturn(self::AMOUNT);
		$this->book->shouldReceive('getAttribute')->with('currency')->andReturn(self::CURRENCY);

		$this->book->shouldReceive('getAttribute')->with('authors')->andReturn($this->wishLists);
		$this->book->shouldReceive('getAttribute')->with('wishlists')->andReturn($this->authors);
		$this->book->shouldReceive('getAttribute')->with('personal_book_infos')->andReturn($this->personalBookInfos);
		$this->book->shouldReceive('getAttribute')->with('tags')->andReturn($this->tags);

		$this->bookToElasticMapper = App::make('BookToElasticMapper');
	}
	
	public function test_mapsCorrectly(){
	    $mappedBook = $this->bookToElasticMapper->map($this->book);

		$this->assertEquals($mappedBook['id'], self::BOOK_ID);
		$this->assertEquals($mappedBook['isbn'], self::ISBN);
		$this->assertEquals($mappedBook['title'], self::TITLE);
		$this->assertEquals($mappedBook['subtitle'], self::SUBTITLE);
		$this->assertEquals($mappedBook['country'], self::PUBLISHER_COUNTRY_ID);
		$this->assertEquals($mappedBook['publisher'], self::PUBLISHER_ID);
		$this->assertEquals($mappedBook['language'], self::LANGUAGE_ID);
		$this->assertEquals($mappedBook['mainAuthor'], self::AUTHOR_NAME . " " . self::AUTHOR_FIRST_NAME);
		$this->assertEquals($mappedBook['genre'], self::GENRE_ID);
		$this->assertEquals($mappedBook['retailPrice']["amount"], self::AMOUNT);
		$this->assertEquals($mappedBook['retailPrice']["currency"], self::CURRENCY);
	}
	

}