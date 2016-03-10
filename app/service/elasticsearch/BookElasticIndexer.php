<?php


use Bendani\PhpCommon\FilterService\Model\FilterReturnType;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookElasticIndexer
{
    const BOOK = 'book';

    /** @var  ElasticSearchClient */
    private $elasticSearchClient;
    /** @var  BookRepository */
    private $bookRepository;

    /**
     * BookElasticIndexer constructor.
     */
    public function __construct()
    {
        $this->elasticSearchClient = App::make('ElasticSearchClient');
        $this->bookRepository = App::make('BookRepository');
    }

    public function indexBooks()
    {
        $books = $this->bookRepository->allWith(array('personal_book_infos', 'book_from_authors'));

        /** @var Book $book */
        foreach ($books as $book) {
            $this->indexBook($book);
        }
    }

    public function indexBookById($book_id)
    {
        $book = $this->bookRepository->find($book_id, array('personal_book_infos', 'book_from_authors'));
        Ensure::objectNotNull('book to index', $book);

        $this->indexBook($book);
    }

    public function deleteBook($book){
            $params = [
                'index' => 'bibliomania',
                'type' => 'book',
                'id' => $book->id
            ];

        $response = $this->elasticSearchClient->getClient()->delete($params);
        return $response;
    }

    /**
     * @param $book
     */
    public function indexBook($book)
    {
        $authors = $this->indexAuthors($book);
        $personalBookInfos = $this->indexPersonalBookInfos($book);
        $tags = $this->indexTags($book);

        $book->load('wishlists');

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
            $bookArray['image'] = $baseUrl . "/bookImages/" . $book->coverImage;
        }

        $book->load('book_from_authors');

        if ($book->book_from_authors !== null) {
            $bookArray['isLinkedToOeuvre'] = count($book->book_from_authors->all()) > 0;
        }

        if ($book->mainAuthor() != null) {
            $bookArray['mainAuthor'] = $book->mainAuthor()->name . " " . $book->mainAuthor()->firstname;
        }


        $params = [
            'index' => $this->elasticSearchClient->getIndexName(),
            'type' => self::BOOK,
            'id' => intval($book->id),
            'body' => $bookArray
        ];

        $responses = $this->elasticSearchClient->getClient()->index($params);
    }


    public function search($userId, $bookFilters, $personalFilters)
    {

        /** @var FilterReturnType $item */
        $filters = array_map(function($item){
            return $item->getValue();
        }, $bookFilters);

        /** @var FilterReturnType $item */
        $personalFilters = array_map(function($item){
            return $item->getValue();
        }, $personalFilters);

        if(count($personalFilters) > 0){
            array_push($filters, ['nested' => [
                'path'=>'personalBookInfos',
                'filter' => ['bool' => ['must' => $personalFilters]]
            ]]);
        }

        $params = [
            'index' => $this->elasticSearchClient->getIndexName(),
            'type' => self::BOOK,
            'size' => 10000,
            'body' => [
                '_source' => ['id', 'title', 'subtitle', 'mainAuthor', 'authors', 'image', 'spriteImage', 'isLinkedToOeuvre', 'retailPrice'],
                'query' => [
                    'filtered' => [
                        'query' => [
                            'match_all' => new \stdClass()
                        ],
                        'filter' => ['bool' => ['must' => $filters]]
                    ]
                ],
                'script_fields' => [
                    'isPersonal' => [
                        'script' => "_source.personalBookInfoUsers.contains($userId)"
                    ],
                    'inCollection' => [
                        'script' => "_source.personalBookInfos.find{ it.userId == $userId } != null && _source.personalBookInfos.find{ it.userId == $userId }.inCollection"
                    ],
                    'personalBookInfoId' => [
                        'script' => "_source.personalBookInfos.find{ it.userId == $userId } == null ? null : _source.personalBookInfos.find{ it.userId == $userId }.id"
                    ],
                    'onWishlist' => [
                        'script' => "_source.wishlistUsers.contains($userId)"
                    ],
                    'read' => [
                        'script' => "_source.readUsers.contains($userId)"
                    ],
                ]
            ]
        ];


        return $this->elasticSearchClient->search($params);
    }

    /**
     * @param $book
     * @return PersonalBookInfo
     */
    private function indexPersonalBookInfos($book)
    {
        $book->load('personal_book_infos');
        /** @var PersonalBookInfo $personalBookInfos */
        $personalBookInfos = array_map(function ($personalBookInfo) {
            $giftInfo = null;
            $buyInfo = null;

            if ($personalBookInfo->gift_info) {
                $giftInfo = ['from' => $personalBookInfo->gift_info->from];
            }

            if ($personalBookInfo->buy_info) {
                $buyInfo = [];

                if($personalBookInfo->buy_info->city){
                    $buyInfo['city'] = [
                            'id' => intval($personalBookInfo->buy_info->city->id),
                            'name' => $personalBookInfo->buy_info->city->name
                    ];
                }
                $buyInfo['price'] = $personalBookInfo->buy_info->price_payed;
                $buyInfo['buy_date'] = $personalBookInfo->buy_info->buy_date;
            }

            /** @var ReadingDate $date */
            $readingDates = array_map(function($date){
                return [
                    'date' => $date->date,
                    'rating' => $date->rating
                ];
            }, $personalBookInfo->reading_dates->all());

            return [
                'id' => intval($personalBookInfo->id),
                'userId' => intval($personalBookInfo->user_id),
                'inCollection' => $personalBookInfo->get_owned(),
                'reasonNotInCollection' => $personalBookInfo->reasonNotInCollection,
                'giftInfo' => $giftInfo,
                'buyInfo' => $buyInfo,
                'readingDates' => $readingDates
            ];
        }, $book->personal_book_infos->all());
        return $personalBookInfos;
    }

    /**
     * @param $book
     * @return array
     */
    private function indexTags($book)
    {
        $tags = array_map(function ($tag) {
            return ['id' => intval($tag->id), 'name' => $tag->name];
        }, $book->tags->all());
        return $tags;
    }

    /**
     * @param $book
     * @return array
     */
    private function indexAuthors($book)
    {
        $authors = array_map(function ($author) {
            return [
                'id' => intval($author->id),
                'firstname' => $author->firstname,
                'lastname' => $author->lastname
            ];
        }, $book->authors->all());
        return $authors;
    }

}