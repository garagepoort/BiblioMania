<?php


use Bendani\PhpCommon\FilterService\Model\FilterReturnType;

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
        $books = $this->bookRepository->allWith(array('personal_book_infos'));

        /** @var Book $book */
        foreach ($books as $book) {
            $authors = array_map(function($author){
                return [
                    'id'=> $author->id,
                    'firstname'=> $author->firstname,
                    'lastname' => $author->lastname
                ];
            }, $book->authors->all());

            $personalBookInfos = $this->indexPersonalBookInfos($book);

            $bookArray = [
                'id' => $book->id,
                'title' => $book->title,
                'subtitle' => $book->subtitle,
                'isbn' => $book->ISBN,
                'authors' => $authors,
                'country' => $book->publisher_country_id,
                'genre' => $book->genre_id,
                'personalBookInfos' => $personalBookInfos
            ];

            $params = [
                'index' => $this->elasticSearchClient->getIndexName(),
                'type' => self::BOOK,
                'id' => $book->id,
                'body' => $bookArray
            ];

            $responses = $this->elasticSearchClient->getClient()->index($params);
        }
    }

    public function search($bookFilters)
    {
        /** @var FilterReturnType $item */
        $filters = array_map(function($item){
            return $item->getValue();
        }, $bookFilters);

        $params = [
            'index' => $this->elasticSearchClient->getIndexName(),
            'type' => self::BOOK,
            'size' => 10000,
            'body' => [
//                'fields' => ['id', 'title', 'subtitle'],
                '_source' => ['id', 'title', 'subtitle', 'personalBookInfos', 'authors'],
                'query' => [
                    'filtered' => [
                        'query' => [
                            'match_all' => new \stdClass()
                        ],
                        'filter' => $filters
                    ]
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
                            'id' => $personalBookInfo->buy_info->city->id,
                            'name' => $personalBookInfo->buy_info->city->name
                    ];
                }
                $buyInfo['price'] = $personalBookInfo->buy_info->price_payed;
                $buyInfo['buy_date'] = $personalBookInfo->buy_info->buy_date;
            }
            return [
                'id' => $personalBookInfo->id,
                'userId' => $personalBookInfo->user_id,
                'inCollection' => $personalBookInfo->get_owned(),
                'reasonNotInCollection' => $personalBookInfo->reasonNotInCollection,
                'giftInfo' => $giftInfo,
                'buyInfo' => $buyInfo
            ];
        }, $book->personal_book_infos->all());
        return $personalBookInfos;
    }


}