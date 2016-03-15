'use strict';

angular.module('com.bendani.bibliomania.create.chart.ui', [
        'com.bendani.php.common.filterservice',
        'com.bendani.bibliomania.book.filter.model'
    ])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/create-chart', {
            templateUrl: '../BiblioMania/views/partials/statistics/create-chart.html',
            controller: 'CreateChartController'
        });
    }])
    .controller('CreateChartController', ['$scope', '$location', 'ChartConfiguration', 'ErrorContainer', 'growl', 'FilterService', 'BookFilter',
        function($scope, $location, ChartConfiguration, ErrorContainer, growl, FilterService, BookFilter){


        $scope.filterServiceId = "chartFilters";
        FilterService.registerFilterService($scope.filterServiceId);
        $scope.submitAttempted = false;
        $scope.model = {};
        $scope.model.conditions = [];

        $scope.data = {};
        $scope.data.xproperties = ChartConfiguration.xproperties(function(){}, ErrorContainer.handleRestError);

        getFilters();

        $scope.createChart = function($formValid){
            $scope.submitAttempted = true;
            if($formValid){
                ChartConfiguration.save($scope.model, function(){
                    growl.addSuccessMessage('Configuratie opgeslagen');
                    $location.path("/statistics");
                }, ErrorContainer.handleRestError);
            }
        };

        function getFilters() {
            BookFilter.query(function (filters) {
                for (var i = 0; i < filters.length; i++) {
                    var filter = filters[i];
                    if (filter.supportedOperators) {
                        filter.selectedOperator = filter.supportedOperators[0];
                    }
                    filter.value = "";
                }
                FilterService.setAllFilters($scope.filterServiceId, filters);
            }, ErrorContainer.handleRestError);
        }
    }]);
