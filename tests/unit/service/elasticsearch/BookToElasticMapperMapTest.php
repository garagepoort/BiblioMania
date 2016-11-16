<?php

use Illuminate\Database\Eloquent\Collection;

class BookToElasticMapperMapTest extends TestCase
{
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
	/** @var  Collection $tags */
	private $tags;

	public function setUp(){
	    parent::setUp();

		$this->authorToElasticMapper = $this->mock('AuthorToElasticMapper');
		$this->personalBookInfoToElasticMapper = $this->mock('PersonalBookInfoToElasticMapper');
		$this->tagToElasticMapper = $this->mock('TagToElasticMapper');

		$this->authors = $this->mockEloquentCollection();
		$this->personalBookInfos = $this->mockEloquentCollection();
		$this->tags = $this->mockEloquentCollection();
		$this->authors->shouldReceive('all')->andReturn(array())->byDefault();
		$this->personalBookInfos->shouldReceive('all')->andReturn(array())->byDefault();
		$this->tags->shouldReceive('all')->andReturn(array())->byDefault();

		$this->book = $this->mockEloquent(Book::class);
		$this->book->shouldReceive('getAttribute')->with('authors')->andReturn($this->authors);
		$this->book->shouldReceive('getAttribute')->with('personal_book_infos')->andReturn($this->personalBookInfos);
		$this->book->shouldReceive('getAttribute')->with('tags')->andReturn($this->tags);

		$this->bookToElasticMapper = App::make('BookToElasticMapper');
	}
	
	public function test_mapsCorrectly(){
	    $mappedBook = $this->bookToElasticMapper->map($this->book);

		$this->assertEquals($mappedBook['id'], $this->book);
	}
	

}