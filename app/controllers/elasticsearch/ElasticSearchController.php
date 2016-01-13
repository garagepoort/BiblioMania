<?php

/**
 * Created by PhpStorm.
 * User: davidmaes
 * Date: 06/01/16
 * Time: 19:56
 */
class ElasticSearchController extends BaseController
{

    /** @var ElasticSearchClient */
    private $elasticSearchClient;
    /** @var BookElasticIndexer */
    private $bookElasticIndexer;

    /**
     * ElasticSearchController constructor.
     */
    public function __construct()
    {
        $this->bookElasticIndexer = App::make('BookElasticIndexer');
        $this->elasticSearchClient = App::make('ElasticSearchClient');
    }


    public function index(){
        $this->elasticSearchClient->createIndex();
        $this->bookElasticIndexer->indexBooks();
    }

    public function clear(){
        $this->elasticSearchClient->clear();
    }
}