<?php

class ChartConfigurationService
{

    public function createChartConfiguration($userId, CreateChartConfigurationRequest $chartConfigurationRequest){
        return DB::transaction(function() use ($userId, $chartConfigurationRequest){
            $chart = new ChartConfiguration();
            $chart->user_id = $userId;
            $chart->type = $chartConfigurationRequest->getType();
            $chart->title = $chartConfigurationRequest->getTitle();
            $chart->xProperty = $chartConfigurationRequest->getXProperty();
            $chart->save();

            foreach($chartConfigurationRequest->getConditions() as $condition){
                  $this->createCondition($chart->id, $condition);
            }
            return $chart;
        });
    }

    private function createCondition($chartConfigId, CreateChartConditionRequest $chartConditionRequest){
        $chartCondition = new ChartCondition();
        $chartCondition->chart_configuration_id = $chartConfigId;
        $chartCondition->property = $chartConditionRequest->getProperty();
        $chartCondition->operator = $chartConditionRequest->getOperator();
        $chartCondition->value = $chartConditionRequest->getValue();
        $chartCondition->save();
    }

    public function createScatterChart($title, $xProperty, $yProperty, $conditions){
        $chart =  new ChartConfiguration();
        $chart->type = "SCATTER";

        $chart->title = $title;
        $chart->xProperty = $xProperty;
        $chart->conditions = $conditions;
        $chart->yProperty = $yProperty;
        return $chart;
    }
}