'use strict';

angular.module('com.bendani.bibliomania.publisher.overview.ui', [
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.title.panel'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/publishers', {
            templateUrl: '../BiblioMania/views/partials/publisher/publishers-overview.html',
            controller: 'PublishersOverviewController'
        });
    }])
    .controller('PublishersOverviewController', ['$scope', 'Publisher', 'ErrorContainer', 'TitlePanelService', '$location',
        function ($scope, Publisher, ErrorContainer, TitlePanelService, $location) {

            function init() {
                TitlePanelService.setTitle('Uitgevers');
                TitlePanelService.setShowPreviousButton(false);

                $scope.searchSeriesQuery = "";
                $scope.predicate = "name";
                $scope.reverseOrder = false;

                $scope.orderValues = [
                    {key: 'Naam', predicate: 'name', width: '50'}
                ];

                loadPublishers();

            }

            $scope.search = function (item) {
                if ((item.name.toLowerCase().indexOf($scope.searchSeriesQuery) !== -1)) {
                    return true;
                }
                return false;
            };

            $scope.goToPublisherDetails = function (publisher) {
                $location.path('/edit-publisher/' + publisher.id);
            };

            $scope.setListView = function (value) {
                $scope.listView = value;
            };

            function loadPublishers() {
                $scope.loading = true;
                $scope.publishers = Publisher.query(function () {
                    $scope.loading = false;
                }, ErrorContainer.handleRestError);
            }

            init();
        }]);