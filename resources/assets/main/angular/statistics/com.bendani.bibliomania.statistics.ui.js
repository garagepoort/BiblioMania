'use strict';

angular.module('com.bendani.bibliomania.statistics.ui', [
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.chart.directive',
    'com.bendani.bibliomania.chart.configuration.model'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/statistics', {
            templateUrl: '../BiblioMania/views/partials/statistics/statistics.html',
            controller: 'StatisticsController'
        });
    }])
    .controller('StatisticsController', ['$scope',
        'ErrorContainer',
        'TitlePanelService',
        'ChartData',
        'ChartConfiguration',
        '$location',
        function ($scope, ErrorContainer, TitlePanelService, ChartData, ChartConfiguration, $location) {

            function init() {
                TitlePanelService.setTitle('Statistieken');
                TitlePanelService.setShowPreviousButton(false);
            }

            $scope.goToCreateChart = function(){
                $location.path('/create-chart');
            };

            $scope.chartConfigurations = ChartConfiguration.query(function(){}, ErrorContainer.handleRestError);


            $scope.onDeleteChart = function(){
                $scope.chartConfigurations = ChartConfiguration.query(function(){}, ErrorContainer.handleRestError);
            };

            init();
        }]);