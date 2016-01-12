<?php
use Elasticsearch\ClientBuilder;

class ElasticSearchClient
{
    private $client;

    /**
     * ElasticSearchClient constructor.
     */
    public function __construct()
    {
        $params = [
            'hosts' => [
                'localhost:9200'
            ],
            'retries' => 2,
            'imNotReal' => 5
        ];

        $this->client = ClientBuilder::fromConfig($params, true);
    }

    public function getClient(){
        return $this->client;
    }

    public function getIndexName(){
        return 'bibliomania';
    }

    public function clear(){
        $params = ['index' => 'bibliomania'];
        $response = $this->client->indices()->delete($params);
    }

    public function search($params)
    {
        $resultSources = array();
        $results = $this->client->search($params);
        foreach($results['hits']['hits'] as $result){
            $source = [];

            if($result['_source']){
                $source = $result['_source'];
            }

            if($result['fields']){
                foreach($result['fields'] as $field => $value){
                    $source[$field] = $value[0];
                }
            }

            array_push($resultSources, $source);
        }
        return $resultSources;
    }

    /**
     * @return array
     */
    public function createIndex()
    {
        $params = [
            'index' => $this->getIndexName(),
            'body' => [
                "settings" => [
                    'index' => [
                        'analysis' => [
                            'analyzer' => ['analyzer_keyword' => ['tokenizer' => 'keyword', 'filter' => 'lowercase'] ]
                        ]
                    ]
                ],
                'mappings' => [
                    'book' => [
                        'properties' => [
                            'title' => [
                                "analyzer" => "analyzer_keyword",
                                "type" => "string"
                            ],
                            'subtitle' => [
                                "analyzer" => "analyzer_keyword",
                                "type" => "string"
                            ],
                            'authors' => [
                                "properties" => [
                                    'firstname' => ['type'=>'string', 'analyzer'=>'analyzer_keyword'],
                                    'lastname' => ['type'=>'string', 'analyzer'=>'analyzer_keyword']
                                ]
                            ],
                            'personalBookInfos' => [
                                'type'=> 'nested',
                                "properties" => [
                                    'giftInfo' => [
                                        'properties' => [
                                            'from' => ['type'=>'string', 'analyzer'=>'analyzer_keyword']
                                        ]
                                    ],
                                    'buyInfo' => [
                                        'properties' => [
                                            'buy_date' => ['type'=>'date', 'format'=>'yyyy-MM-dd']
                                        ]
                                    ],
                                    'readingDates' => [
                                        'properties' => [
                                            'rating' => [ 'type' => 'integer' ],
                                            'date' => ['type'=>'date', 'format'=>'yyyy-MM-dd']
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->client->indices()->create($params);
    }
}