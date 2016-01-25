'use strict';

angular.module('com.bendani.bibliomania.statistics.ui', [
    'com.bendani.bibliomania.title.panel'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/statistics', {
            templateUrl: '../BiblioMania/views/partials/statistics/statistics.html',
            controller: 'StatisticsController'
        });
    }])
    .controller('StatisticsController', ['$scope', 'ErrorContainer', 'TitlePanelService',
        function ($scope, ErrorContainer, TitlePanelService) {

            function init() {
                TitlePanelService.setTitle('Statistieken');
                TitlePanelService.setShowPreviousButton(false);

            }

            init();
        }]);