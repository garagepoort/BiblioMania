<?php

use Bendani\PhpCommon\Utils\Ensure;

class ChartConfigurationService
{

    /** @var  ChartConfigurationRepository  */
    private $chartConfigurationRepository;

    /**
     * ChartConfigurationService constructor.
     */
    public function __construct()
    {
        $this->chartConfigurationRepository = App::make('ChartConfigurationRepository');
    }


    public function createChartConfiguration($userId, CreateChartConfigurationRequest $chartConfigurationRequest){
        return DB::transaction(function() use ($userId, $chartConfigurationRequest){
            $chart = new ChartConfiguration();
            $chart->user_id = $userId;
            $chart->type = "BAR";
            $chart->title = $chartConfigurationRequest->getTitle();
            $chart->xProperty = $chartConfigurationRequest->getXProperty();
            $chart->filters = json_encode($chartConfigurationRequest->getFilters());
            $chart->save();
            return $chart;
        });
    }

    public function updateChartConfiguration($userId, UpdateChartConfigurationFromJsonAdapter $chartConfigurationRequest){
        $chart = $this->getById($chartConfigurationRequest->getId());

        return DB::transaction(function() use ($userId, $chartConfigurationRequest, $chart){
            $chart->type = "BAR";
            $chart->title = $chartConfigurationRequest->getTitle();
            $chart->xProperty = $chartConfigurationRequest->getXProperty();
            $chart->filters = json_encode($chartConfigurationRequest->getFilters());
            $chart->save();
            return $chart;
        });
    }


    public function createScatterChart($title, $xProperty, $yProperty, $conditions){
        $chart =  new ChartConfiguration();
        $chart->type = "SCATTER";

        $chart->title = $title;
        $chart->xProperty = $xProperty;
        $chart->filters = $conditions;
        $chart->yProperty = $yProperty;
        return $chart;
    }

    public function getById($id)
    {
        $chartConfiguration = $this->chartConfigurationRepository->find($id);
        Ensure::objectNotNull('chartConfiguration', $chartConfiguration);
        return $chartConfiguration;
    }
}