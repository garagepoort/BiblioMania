<?php

class ChartConfigurationController extends BaseController
{

    /** @var  ChartDataService  */
    private $chartDataService;
    /** @var  ChartConfigurationService  */
    private $chartConfigurationService;
    /** @var  ChartConfigurationRepository  */
    private $chartConfigurationRepository;
    /** @var  JsonMappingService */
    private $jsonMappingService;

    /**
     * ChartConfigurationController constructor.
     */
    public function __construct()
    {
        $this->chartDataService = App::make('ChartDataService');
        $this->chartConfigurationService = App::make('ChartConfigurationService');
        $this->chartConfigurationRepository = App::make('ChartConfigurationRepository');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getXProperties(){
        $xPropertiesToJsonAdapter = new XPropertiesToJsonAdapter();
        return $xPropertiesToJsonAdapter->mapToJson(array(
            "genre" => "genre.name"
        ));
    }

    public function createChartConfiguration(){
        $chartConfiguration = $this->jsonMappingService->mapInputToJson(Input::get(), new CreateChartConfigurationFromJsonAdapter());
        $this->chartConfigurationService->createChartConfiguration(Auth::user()->id, $chartConfiguration);
    }

    public function getChartConfigurations(){
        $chartConfigurations = $this->chartConfigurationRepository->allFromUser(Auth::user()->id)->all();

        return array_map(function($chartConfiguration){
            $adapter = new ChartConfigurationToJsonAdapter($chartConfiguration);
            return $adapter->mapToJson();
        }, $chartConfigurations);
    }

    public function getChartData($configurationId){
//        $condition1 = new ChartCondition("personal_book_info.read", "=", true);
//        $condition2 = new ChartCondition("reading_date.rating", ">", 0);
//        $chartConfiguration = ChartConfiguration::constructBar("title", "genre.name", [$condition2, $condition1]);
        $chartConfiguration = $this->chartConfigurationRepository->find($configurationId);
        Ensure::objectNotNull("chartConfiguration", $chartConfiguration);

        $chartData = $this->chartDataService->getChartDataFromConfiguration(Auth::user()->id, $chartConfiguration);
        $chartDataToJsonAdapter = new ChartDataToJsonAdapter($chartData);
        return $chartDataToJsonAdapter->mapToJson();
    }
}