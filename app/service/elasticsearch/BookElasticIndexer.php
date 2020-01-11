<?php


use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterReturnType;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\StringUtils;

class BookElasticIndexer
{
    const BOOK = 'book';

    /** @var  ElasticSearchClient */
    private $elasticSearchClient;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  BookToElasticMapper $bookToElasticMapper */
    private $bookToElasticMapper;
    /** @var  \Katzgrau\KLogger\Logger */
    private $logger;

    /**
     * BookElasticIndexer constructor.
     */
    public function __construct()
    {
        $this->elasticSearchClient = App::make('ElasticSearchClient');
        $this->bookRepository = App::make('BookRepository');
        $this->bookToElasticMapper = App::make('BookToElasticMapper');
        $this->logger = App::make('Logger');
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
        $bookArray = $this->bookToElasticMapper->map($book);

        $params = [
            'index' => $this->elasticSearchClient->getIndexName(),
            'type' => self::BOOK,
            'id' => intval($book->id),
            'body' => $bookArray
        ];

        $responses = $this->elasticSearchClient->getClient()->index($params);
    }


    /**
     * @param FilterReturnType[] $bookFilters
     */
    public function search($userId, $bookFilters, $personalFilters)
    {
        $filters = $this->filtersByClause($bookFilters);

        if(count($personalFilters) > 0) {
            array_push($personalFilters, FilterBuilder::term('personalBookInfos.userId', $userId));
            $this->logger->info('test personal: ' . json_encode($personalFilters));
            if(count($personalFilters) > 0){
                if (!array_key_exists('must', $filters)) {
                    $filters['must'] = array();
                }
                array_push($filters['must'], ['nested' => [
                    'path'=>'personalBookInfos',
                    'query' => ['bool' => $this->filtersByClause($personalFilters)]
                ]]);
            }
        }

        $this->logger->info('test' . json_encode($filters));

        $body = [
            '_source' => ['id', 'title', 'subtitle', 'mainAuthor', 'authors', 'image', 'spriteImage', 'isLinkedToOeuvre', 'retailPrice', 'firstPrintPublicationDate'],
            'script_fields' => [
                'isPersonal' => [
                    'script' => [
                        "inline" => "params._source.personalBookInfoUsers.contains($userId)"
                    ]
                ],
                'inCollection' => [
                    'script' => [
                        "inline" => "params._source.personalBookInfos.find(it -> it.userId == $userId) != null && params._source.personalBookInfos.find(it -> it.userId == $userId).inCollection"
                    ]
                ],
                'personalBookInfoId' => [
                    'script' => [
                        "inline" => "params._source.personalBookInfos.find(it -> it.userId == $userId) == null ? null : params._source.personalBookInfos.find(it -> it.userId == $userId).id"
                    ]
                ],
                'onWishlist' => [
                    'script' => [
                        "inline" => "params._source.wishlistUsers.contains($userId)"
                    ]
                ],
                'read' => [
                    'script' => [
                        "inline" => "params._source.readUsers.contains($userId)"
                    ]
                ],
            ]
        ];

        if(sizeof($filters) > 0) {
            $this->logger->info("ADDING QUERY" );
            $body['query'] = [
                'bool' => [
                    'must' => [
                        'match_all' => new \stdClass()
                    ],
                    'filter' => ['bool' => $filters]
                ]
            ];
        }

        $params = [
            'index' => $this->elasticSearchClient->getIndexName(),
            'type' => self::BOOK,
            'size' => 10000,
            'body' => $body
        ];

        $this->logger->info("BOOKS SEARCH QUERY: " . json_encode($params));
        return $this->elasticSearchClient->search($params);
    }


    /**
     * @param FilterReturnType[] $filters
     */
    private function filtersByClause($filters) {
        $byClause = array();
        foreach ($filters as $filter) {
            if (!array_key_exists($filter->getClause(), $byClause)) {
                $byClause[$filter->getClause()] = array();
            }
            array_push($byClause[$filter->getClause()], $filter->getValue());
        }
        return $byClause;
    }
}
