<?php

use Bendani\PhpCommon\FilterService\Model\ChartConfigurationXProperty;
use Bendani\PhpCommon\Utils\Ensure;

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
        return array(
            XPropertiesToJsonAdapter::createXProperty("genre", ChartConfigurationXProperty::GENRE),
            XPropertiesToJsonAdapter::createXProperty("tag", ChartConfigurationXProperty::TAG),
            XPropertiesToJsonAdapter::createXProperty("Leesjaar", ChartConfigurationXProperty::READING_DATE_YEAR),
            XPropertiesToJsonAdapter::createXProperty("PublicatieJaar", ChartConfigurationXProperty::PUBLICATION_YEAR),
            XPropertiesToJsonAdapter::createXProperty("Gift jaar", ChartConfigurationXProperty::GIFT_YEAR),
            XPropertiesToJsonAdapter::createXProperty("Aankoopjaar", ChartConfigurationXProperty::BUY_YEAR),
            XPropertiesToJsonAdapter::createXProperty("Gekregen van", ChartConfigurationXProperty::GIFT_FROM)
        );
    }

    public function createChartConfiguration(){
        $chartConfiguration = $this->jsonMappingService->mapInputToJson(Input::get(), new CreateChartConfigurationFromJsonAdapter());
        $this->chartConfigurationService->createChartConfiguration(Auth::user()->id, $chartConfiguration);
    }

    public function updateChartConfiguration(){
        $chartConfiguration = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateChartConfigurationFromJsonAdapter());

        $this->chartConfigurationService->updateChartConfiguration(Auth::user()->id, $chartConfiguration);
    }

    public function getChartConfigurations(){
        $chartConfigurations = $this->chartConfigurationRepository->allFromUser(Auth::user()->id)->all();

        return array_map(function($chartConfiguration){
            $adapter = new ChartConfigurationToJsonAdapter($chartConfiguration);
            return $adapter->mapToJson();
        }, $chartConfigurations);
    }

    public function getChartConfiguration($id){
        $chartConfiguration = $this->chartConfigurationService->getById($id);
        $adapter = new ChartConfigurationToJsonAdapter($chartConfiguration);
        return $adapter->mapToJson();
    }

    public function getChartData($configurationId){
        $chartConfiguration = $this->chartConfigurationRepository->find($configurationId);
        Ensure::objectNotNull("chartConfiguration", $chartConfiguration);

        $chartData = $this->chartDataService->getChartDataFromConfiguration(Auth::user()->id, $chartConfiguration);
        $chartDataToJsonAdapter = new ChartDataToJsonAdapter($chartData);
        return $chartDataToJsonAdapter->mapToJson();
    }
}