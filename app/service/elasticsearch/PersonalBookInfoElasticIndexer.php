<?php


class PersonalBookInfoElasticIndexer
{
    const PERSONAL_BOOK_INFO = 'personalBookInfo';

    /** @var  ElasticSearchClient */
    private $elasticSearchClient;
    /** @var  PersonalBookInfoRepository */
    private $personalBookInfoRepository;

    /**
     * BookElasticIndexer constructor.
     */
    public function __construct()
    {
        $this->elasticSearchClient = App::make('ElasticSearchClient');
        $this->personalBookInfoRepository = App::make('PersonalBookInfoRepository');
    }

    public function index()
    {
        $personalBookInfos = $this->personalBookInfoRepository->all();

        /** @var PersonalBookInfo $personalBookInfo */
        foreach ($personalBookInfos as $personalBookInfo) {
            $personalArray = [
                'id' => $personalBookInfo->id,
                'userId' => $personalBookInfo->user_id,
                'inCollection' => $personalBookInfo->get_owned(),
                'reasonNotInCollection' => $personalBookInfo->reasonNotInCollection
            ];


            if ($personalBookInfo->retail_price) {
                $personalArray['retailPrice'] = [
                    'amount' => $personalBookInfo->retail_price,
                    'currency' => $personalBookInfo->currency
                ];
            }

            $params = [
                'index' => $this->elasticSearchClient->getIndexName(),
                'type' => self::PERSONAL_BOOK_INFO,
                'id' => $personalBookInfo->id,
                'parent' => $personalBookInfo->book_id,
                'body' => $personalArray
            ];
            $responses = $this->elasticSearchClient->getClient()->index($params);
        }

    }

}