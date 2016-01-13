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
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        $this->elasticSearchClient->createIndex();
        $this->bookElasticIndexer->indexBooks();
        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
    }

    public function clear(){
        $this->elasticSearchClient->clear();
    }
}