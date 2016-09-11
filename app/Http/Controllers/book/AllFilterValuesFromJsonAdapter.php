<?php

class AllFilterValuesFromJsonAdapter
{
    /** @var  JsonMappingService */
    private $jsonMappingService;

    private $filters;

    public function __construct($filtersInJson)
    {
        $this->jsonMappingService = App::make('JsonMappingService');
        $this->filters = array();
        foreach($filtersInJson as $filter){
            if($filter['id'] === FilterType::BOOK_BUY_DATE || $filter['id'] === FilterType::BOOK_RETRIEVE_DATE){
                array_push($this->filters, $this->jsonMappingService->mapInputToJson($filter, new DateFilterValueFromJsonAdapter()));
            }else if($filter['id'] === FilterType::BOOK_READING_DATE){
                array_push($this->filters, $this->jsonMappingService->mapInputToJson($filter, new PartialDateFilterValueFromJsonAdapter()));
            }else{
                array_push($this->filters, $this->jsonMappingService->mapInputToJson($filter, new FilterValueFromJsonAdapter()));
            }
        }
    }

    public function getFilters(){
        return $this->filters;
    }
}