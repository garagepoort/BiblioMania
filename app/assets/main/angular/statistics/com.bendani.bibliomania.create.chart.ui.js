'use strict';

angular.module('com.bendani.bibliomania.create.chart.ui', [
        'com.bendani.php.common.filterservice',
        'com.bendani.bibliomania.chart.filter.model'
    ])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/create-chart', {
            templateUrl: '../BiblioMania/views/partials/statistics/create-chart.html',
            controller: 'CreateChartController',
            resolve: {
                chartModel: function () {
                    return {};
                },
                onSave: ['ChartConfiguration', 'FilterService', '$route', 'ErrorContainer', 'growl', '$location', function (ChartConfiguration, FilterService, $route, ErrorContainer, growl, $location) {
                    return function (model, filterServiceId) {
                        model.filters = FilterService.convertFiltersToJson(filterServiceId);
                        ChartConfiguration.save(model, function(){
                            growl.addSuccessMessage('Configuratie opgeslagen');
                            $location.path("/statistics");
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
        $routeProvider.when('/edit-chart/:id', {
            templateUrl: '../BiblioMania/views/partials/statistics/create-chart.html',
            controller: 'CreateChartController',
            resolve: {
                chartModel: ['ChartConfiguration', '$route', 'ErrorContainer', function (ChartConfiguration, $route, ErrorContainer) {
                    return ChartConfiguration.get({id: $route.current.params.id}, function () {}, ErrorContainer.handleRestError);
                }],
                onSave: ['ChartConfiguration', 'FilterService', '$route', 'ErrorContainer', 'growl', '$location', function (ChartConfiguration, FilterService, $route, ErrorContainer, growl, $location) {
                    return function (model, filterServiceId) {
                        model.filters = FilterService.convertFiltersToJson(filterServiceId);
                        ChartConfiguration.update(model, function(){
                            growl.addSuccessMessage('Configuratie opgeslagen');
                            $location.path("/statistics");
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
    }])
    .controller('CreateChartController', ['$scope', '$location', 'ChartConfiguration', 'ErrorContainer', 'growl', 'FilterService', 'ChartFilter', 'onSave', 'chartModel',
        function($scope, $location, ChartConfiguration, ErrorContainer, growl, FilterService, ChartFilter, onSave, chartModel){


        $scope.filterServiceId = "chartFilters";
        FilterService.registerFilterService($scope.filterServiceId);
        $scope.submitAttempted = false;
        $scope.model = chartModel;

        $scope.data = {};
        $scope.data.showFilterRefreshButton = false;
        $scope.data.xproperties = ChartConfiguration.xproperties(function(){}, ErrorContainer.handleRestError);

        getFilters();

        $scope.createChart = function($formValid){
            $scope.submitAttempted = true;
            if($formValid){
                onSave($scope.model, $scope.filterServiceId);
            }
        };

        function getFilters() {
            ChartFilter.query(function (filters) {
                for (var i = 0; i < filters.length; i++) {
                    var filter = filters[i];
                    if (filter.supportedOperators) {
                        filter.selectedOperator = filter.supportedOperators[0];
                    }
                    filter.value = "";
                }
                FilterService.setAllFilters($scope.filterServiceId, filters);
                if($scope.model.filters){
                    FilterService.setFilterValues($scope.filterServiceId, $scope.model.filters);
                }
            }, ErrorContainer.handleRestError);
        }
    }]);
