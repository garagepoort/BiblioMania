<?php

class ChartConfigurationController extends BaseController
{

    /** @var  ChartDataService  */
    private $chartDataService;
    /** @var  ChartConfigurationService  */
    private $chartConfigurationService;
    /** @var  JsonMappingService */
    private $jsonMappingService;

    /**
     * ChartConfigurationController constructor.
     */
    public function __construct()
    {
        $this->chartDataService = App::make('ChartDataService');
        $this->chartConfigurationService = App::make('ChartConfigurationService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function createChartConfiguration(){
        $chartConfiguration = $this->jsonMappingService->mapInputToJson(Input::get(), new CreateChartConfigurationFromJsonAdapter());
        $this->chartConfigurationService->createChartConfiguration(Auth::user()->id, $chartConfiguration);
    }

    public function getChartConfigurations(){
        $condition1 = new ChartCondition("personal_book_info.read", "=", true);
        $condition2 = new ChartCondition("reading_date.rating", ">", 0);
        $chartConfiguration = ChartConfiguration::constructBar("title", "genre.name", [$condition2, $condition1]);
        $chartConfigurations = [$chartConfiguration];

        return array_map(function($chartConfiguration){
            $adapter = new ChartConfigurationToJsonAdapter($chartConfiguration);
            return $adapter->mapToJson();
        }, $chartConfigurations);
    }

    public function getChartData($configurationId){
        $condition1 = new ChartCondition("personal_book_info.read", "=", true);
        $condition2 = new ChartCondition("reading_date.rating", ">", 0);
        $chartConfiguration = ChartConfiguration::constructBar("title", "genre.name", [$condition2, $condition1]);

        $chartData = $this->chartDataService->getChartDataFromConfiguration(Auth::user()->id, $chartConfiguration);
        $chartDataToJsonAdapter = new ChartDataToJsonAdapter($chartData);
        return $chartDataToJsonAdapter->mapToJson();
    }
}