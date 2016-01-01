<?php

class AllFiltersFromJsonAdapter
{
    /** @var  JsonMappingService */
    private $jsonMappingService;

    private $filters;

    public function __construct($filtersInJson)
    {
        $this->jsonMappingService = App::make('JsonMappingService');
        $this->filters = array();
        foreach($filtersInJson as $filter){
            if($filter['id'] === "personal-buy_date"){
                array_push($this->filters, $this->jsonMappingService->mapInputToJson($filter, new DateFilterFromJsonAdapter()));
            }else{
                array_push($this->filters, $this->jsonMappingService->mapInputToJson($filter, new FilterFromJsonAdapter()));
            }
        }
    }

    public function getFilters(){
        return $this->filters;
    }
}