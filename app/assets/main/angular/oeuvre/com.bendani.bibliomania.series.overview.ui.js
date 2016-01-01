'use strict';

angular.module('com.bendani.bibliomania.series.overview.ui', [
    'com.bendani.bibliomania.serie.model',
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.book.overview.service',
    'com.bendani.bibliomania.title.panel'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/series', {
            templateUrl: '../BiblioMania/views/partials/book/series-overview.html',
            controller: 'SeriesOverviewController'
        });
    }])
    .controller('SeriesOverviewController', ['$scope', 'Serie', 'ErrorContainer', 'TitlePanelService', 'BookOverviewService', 'Book', '$location',
        function ($scope, Serie, ErrorContainer, TitlePanelService, BookOverviewService, Book, $location) {

            var selectBookHandler = function (book) {
                if ($scope.bookDetailPanelOpen && $scope.selectedBook.id === book.id) {
                    $scope.bookDetailPanelOpen = false;
                } else {
                    $scope.selectedBook = Book.get({id: book.id}, function () {
                    }, ErrorContainer.handleRestError);
                    $scope.bookDetailPanelOpen = true;
                }
            };

            function init() {
                TitlePanelService.setTitle('Boeken reeksen');
                TitlePanelService.setShowPreviousButton(false);

                $scope.searchSeriesQuery = "";
                $scope.predicate = "name";
                $scope.reverseOrder = false;

                $scope.orderValues = [
                    {key: 'Naam', predicate: 'name', width: '50'}
                ];

                loadSeries();

                BookOverviewService.registerHandler(selectBookHandler);
                $scope.$on('$destroy', function () {
                    BookOverviewService.deregisterHandler(selectBookHandler);
                });

            }

            $scope.search = function (item) {
                if ((item.name.toLowerCase().indexOf($scope.searchSeriesQuery) !== -1)) {
                    return true;
                }
                return false;
            };

            $scope.onImageClickBook = function(book){
                BookOverviewService.selectBook(book);
            };

            $scope.onEditBook = function(book){
                $location.path('/book-details/' + book.id);
            };

            $scope.setListView = function (value) {
                $scope.listView = value;
            };

            function loadSeries() {
                $scope.loading = true;
                $scope.series = Serie.query(function () {
                    $scope.loading = false;
                }, ErrorContainer.handleRestError);
            }

            init();
        }]);