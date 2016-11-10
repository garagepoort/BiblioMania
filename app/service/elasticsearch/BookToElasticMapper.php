<?php

use Bendani\PhpCommon\Utils\StringUtils;

class BookToElasticMapper
{

	/** @var  AuthorToElasticMapper $authorToElasticMapper */
	private $authorToElasticMapper;
	/** @var  PersonalBookInfoToElasticMapper $personalBookInfoToElasticMapper */
	private $personalBookInfoToElasticMapper;
	/** @var  TagToElasticMapper $tagToElasticMapper */
	private $tagToElasticMapper;

	/**
	 * BookToElasticMapper constructor.
	 */
	public function __construct()
	{
		$this->authorToElasticMapper = App::make('AuthorToElasticMapper');
		$this->personalBookInfoToElasticMapper = App::make('PersonalBookInfoToElasticMapper');
		$this->tagToElasticMapper = App::make('TagToElasticMapper');
	}


	public function map(Book $book){
		$book->load('personal_book_infos');
		$book->load('wishlists');
		$book->load('authors');
		$book->load('book_from_authors');

		$authors = $this->authorToElasticMapper->mapAuthors($book->authors->all());
		$personalBookInfos = $this->personalBookInfoToElasticMapper->mapPersonalBookInfos($book->personal_book_infos->all());
		$tags = $this->tagToElasticMapper->mapTags($book->tags->all());


		$readUsers = [];
		/** @var PersonalBookInfo $personalBookInfo */
		foreach($book->personal_book_infos as $personalBookInfo){
			if(count($personalBookInfo->reading_dates) > 0){
				array_push($readUsers, intval($personalBookInfo->user_id));
			}
		}

		$bookArray = [
			'id' => intval($book->id),
			'title' => $book->title,
			'subtitle' => $book->subtitle,
			'isbn' => $book->ISBN,
			'authors' => $authors,
			'country' => $book->publisher_country_id,
			'language' => $book->language_id,
			'publisher' => $book->publisher_id,
			'mainAuthor' => $book->mainAuthor()->name . " " . $book->mainAuthor()->firstname,
			'genre' => $book->genre_id,
			'retailPrice' => ['amount' => $book->retail_price, 'currency' => $book->currency],
			'wishlistUsers' => array_map(function($item){ return intval($item->user_id); }, $book->wishlists->all()),
			'personalBookInfoUsers' => array_map(function($item){ return intval($item->user_id); }, $book->personal_book_infos->all()),
			'readUsers' => $readUsers,
			'personalBookInfos' => $personalBookInfos,
			'tags' => $tags
		];

		if (!StringUtils::isEmpty($book->coverImage)) {
			$imageToJsonAdapter = new ImageToJsonAdapter();
			$imageToJsonAdapter->fromBook($book);
			$bookArray['spriteImage'] = $imageToJsonAdapter->mapToJson();

			$baseUrl = URL::to('/');
			$bookArray['image'] = $baseUrl . "/" . Config::get("properties.bookImagesLocation") . "/" . $book->coverImage;
		}

		if ($book->book_from_authors !== null) {
			$bookArray['isLinkedToOeuvre'] = count($book->book_from_authors->all()) > 0;
		}

		return $bookArray;
	}

}