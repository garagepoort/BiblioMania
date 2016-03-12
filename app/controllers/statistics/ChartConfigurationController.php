<?php

class ChartConfigurationController extends BaseController
{

    /** @var  ChartDataService  */
    private $chartDataService;

    /**
     * ChartConfigurationController constructor.
     */
    public function __construct()
    {
        $this->chartDataService = App::make('ChartDataService');
    }

    public function getChartConfigurations(){
        $chartConfigurations = [new ChartConfiguration("title", 'genre', ["author"])];
        return array_map(function($chartConfiguration){
            $adapter = new ChartConfigurationToJsonAdapter($chartConfiguration);
            return $adapter->mapToJson();
        }, $chartConfigurations);
    }

    public function getChartData($configurationId){
        $chartConfiguration = new ChartConfiguration("title", 'genre.name', ["genre.name", "personal_book_info.read"]);
        $chartData = $this->chartDataService->getChartDataFromConfiguration(Auth::user()->id, $chartConfiguration);
        $chartDataToJsonAdapter = new ChartDataToJsonAdapter($chartData);
        return $chartDataToJsonAdapter->mapToJson();
    }
}