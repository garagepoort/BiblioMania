'use strict';

angular.module('com.bendani.bibliomania.statistics.ui', [
    'com.bendani.bibliomania.add.chart.modal.service',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.chart.data.model'])
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
        function ($scope, ErrorContainer, TitlePanelService, AddChartModalService, ChartData) {

            function init() {
                TitlePanelService.setTitle('Statistieken');
                TitlePanelService.setShowPreviousButton(false);

            }

            $scope.openAddChartModal = function(){
                AddChartModalService.show(function(){

                });
            };

            $scope.chartData = ChartData.get({ id: '12' }, function(){}, ErrorContainer.handleRestError);

            init();
        }]);