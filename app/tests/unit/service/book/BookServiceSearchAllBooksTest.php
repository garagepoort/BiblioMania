<?php

namespace tests\unit\service;

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use BookElasticIndexer;
use BookFilterManager;
use BookService;
use FilterHandlerGroup;
use FilterHistoryService;
use FilterValueTestImpl;
use Illuminate\Support\Facades\App;
use TestCase;


class BookServiceSearchAllBooksTest extends TestCase
{

    const USER_ID = 1;
    const PERSONAL_FILTER_ID = 123;
    const PERSONAL_FILTER_VALUE = "some value";
    const NON_PERSONAL_FILTER_VALUE = "some other value";
    const NON_PERSONAL_FILTER_ID = 2;

    /** @var BookService $bookService */
    private $bookService;
    /** @var FilterHistoryService $filterHistoryService */
    private $filterHistoryService;
    /** @var BookFilterManager $bookFilterManager */
    private $bookFilterManager;
    /** @var Filter $personalFilter */
    private $personalFilter;
    /** @var Filter $nonPersonalFilter */
    private $nonPersonalFilter;
    /** @var BookElasticIndexer $bookElasticIndexer */
    private $bookElasticIndexer;
    /** @var FilterHandler $personalFilterHandler */
    private $personalFilterHandler;
    /** @var FilterHandler $nonPersonalFilterHandler */
    private $nonPersonalFilterHandler;


    public function setUp(){
        parent::setUp();
        $this->filterHistoryService = $this->mock('FilterHistoryService');
        $this->bookFilterManager = $this->mock('BookFilterManager');
        $this->personalFilter = $this->mock('Filter');
        $this->nonPersonalFilter = $this->mock('Filter');
        $this->bookElasticIndexer = $this->mock('BookElasticIndexer');

        $this->personalFilterHandler = $this->mock('FilterHandler');
        $this->nonPersonalFilterHandler = $this->mock('FilterHandler');

        $this->personalFilter->shouldReceive('getGroup')->andReturn('personal');
        $this->nonPersonalFilter->shouldReceive('getGroup')->andReturn('');

        $this->bookService = App::make('BookService');
    }

    public function test_callsIndexerWithCorrectFiltersAndReturnsBooks(){
        $personalFilterValue = $this->createFilter(self::PERSONAL_FILTER_ID, self::PERSONAL_FILTER_VALUE, FilterOperator::EQUALS);
        $nonPersonalFilterValue = $this->createFilter(self::NON_PERSONAL_FILTER_ID, self::PERSONAL_FILTER_VALUE, FilterOperator::EQUALS);
        $filters = array(
            $personalFilterValue,
            $nonPersonalFilterValue
        );

        $books = array('book this', 'book that');
        
        $this->filterHistoryService->shouldReceive('addFiltersToHistory')->with($filters)->once();
        $this->bookFilterManager->shouldReceive('getFilter')->with(self::PERSONAL_FILTER_ID)->andReturn($this->personalFilter);
        $this->bookFilterManager->shouldReceive('getFilter')->with(self::NON_PERSONAL_FILTER_ID)->andReturn($this->nonPersonalFilter);

        $this->bookFilterManager->shouldReceive('handle')->with(FilterHandlerGroup::ELASTIC, $nonPersonalFilterValue)->andReturn($this->nonPersonalFilterHandler);
        $this->bookFilterManager->shouldReceive('handle')->with(FilterHandlerGroup::ELASTIC, $personalFilterValue)->andReturn($this->personalFilterHandler);

        $onlyPersonalBooksFilter = FilterBuilder::terms('personalBookInfoUsers', [self::USER_ID]);
        $this->bookElasticIndexer->shouldReceive('search')->with(self::USER_ID, array($this->nonPersonalFilterHandler, $onlyPersonalBooksFilter), array($this->personalFilterHandler))->once()->andReturn($books);

        $result = $this->bookService->searchAllBooks(self::USER_ID, $filters);

        $this->assertEquals($result, $books);
    }

    public function test_whenNoPersonalFilterBooksAreNotFilteredOnPersonalBooks(){
        $nonPersonalFilterValue = $this->createFilter(self::NON_PERSONAL_FILTER_ID, self::NON_PERSONAL_FILTER_VALUE, FilterOperator::EQUALS);
        $filters = array(
            $nonPersonalFilterValue
        );

        $books = array('book this', 'book that');

        $this->filterHistoryService->shouldReceive('addFiltersToHistory')->with($filters)->once();
        $this->bookFilterManager->shouldReceive('getFilter')->with(self::NON_PERSONAL_FILTER_ID)->andReturn($this->nonPersonalFilter);
        $this->bookFilterManager->shouldReceive('handle')->with(FilterHandlerGroup::ELASTIC, $nonPersonalFilterValue)->andReturn($this->nonPersonalFilterHandler);
        $this->bookElasticIndexer->shouldReceive('search')->with(self::USER_ID, array($this->nonPersonalFilterHandler), array())->once()->andReturn($books);

        $result = $this->bookService->searchAllBooks(self::USER_ID, $filters);

        $this->assertEquals($result, $books);
    }

    private function createFilter($id, $value, $operator){
        $filter = new FilterValueTestImpl();
        $filter->setId($id);
        $filter->setValue($value);
        $filter->setOperator($operator);
        return $filter;
    }

}
