<?php

class BookFilterHandler
{

    /** @var array  */
    private $filters;

    public function __construct()
    {
        $this->filters = array(
            "book.title" => new BookTitleFilterHandler(),
            "personal.owned" => new BookOwnedFilterHandler(),
            "personal.read" => new BookReadFilterHandler()
        );
    }

    public function handle($filterId, $queryBuilder, $value){
        /** @var FilterHandler $handler */
        $handler = $this->filters[$filterId];
        return $handler->handleFilter($queryBuilder, $value);
    }

    public function getFilters()
    {
        return $this->filters;
    }
}