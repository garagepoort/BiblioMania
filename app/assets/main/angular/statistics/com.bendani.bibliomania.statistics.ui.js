'use strict';

angular.module('com.bendani.bibliomania.statistics.ui', [
    'com.bendani.bibliomania.add.chart.modal.service',
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
        'AddChartModalService',
        'ChartData',
        'ChartConfiguration',
        function ($scope, ErrorContainer, TitlePanelService, AddChartModalService, ChartData, ChartConfiguration) {

            function init() {
                TitlePanelService.setTitle('Statistieken');
                TitlePanelService.setShowPreviousButton(false);

            }

            $scope.openAddChartModal = function(){
                AddChartModalService.show(function(){

                });
            };

            $scope.chartConfigurations = ChartConfiguration.get(function(){}, ErrorContainer.handleRestError);

            init();
        }]);