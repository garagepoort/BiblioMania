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

    /**
     * BookElasticIndexer constructor.
     */
    public function __construct()
    {
        $this->elasticSearchClient = App::make('ElasticSearchClient');
        $this->bookRepository = App::make('BookRepository');
        $this->bookToElasticMapper = App::make('BookToElasticMapper');
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


    public function search($userId, $bookFilters, $personalFilters)
    {
        $filters = array_map(function($item){ return $item->getValue(); }, $bookFilters);

        if(count($personalFilters) > 0) {
            array_push($personalFilters, FilterBuilder::term('personalBookInfos.userId', $userId));
            $personalFilters = array_map(function($item){ return $item->getValue(); }, $personalFilters);
            if(count($personalFilters) > 0){
                array_push($filters, ['nested' => [
                    'path'=>'personalBookInfos',
                    'filter' => ['bool' => ['must' => $personalFilters]]
                ]]);
            }
        }

        $params = [
            'index' => $this->elasticSearchClient->getIndexName(),
            'type' => self::BOOK,
            'size' => 10000,
            'body' => [
                '_source' => ['id', 'title', 'subtitle', 'mainAuthor', 'authors', 'image', 'spriteImage', 'isLinkedToOeuvre', 'retailPrice', 'firstPrintPublicationDate'],
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

}