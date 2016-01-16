angular
    .module('com.bendani.bibliomania.book.detail.directive', ['com.bendani.bibliomania.book.model',
        'com.bendani.bibliomania.book.overview.service',
        'com.bendani.bibliomania.currency.service'])
    .directive('bookDetail', function (){
        return {
            scope: {},
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-directive.html",
            controller: ['$scope', 'BookOverviewService', 'DateService', 'Book', 'CurrencyService', 'ErrorContainer', function($scope, BookOverviewService, DateService, Book, CurrencyService, ErrorContainer){

                var selectBookHandler = function (book) {
                    if ($scope.bookDetailPanelOpen && $scope.selectedBook.id === book.id) {
                        $scope.bookDetailPanelOpen = false;
                    } else {
                        $scope.selectedBook = Book.get({id: book.id}, function () {
                        }, ErrorContainer.handleRestError);
                        $scope.bookDetailPanelOpen = true;
                    }
                };

                function init(){
                    BookOverviewService.registerHandler(selectBookHandler);
                    $scope.$on('$destroy', function () {
                        BookOverviewService.deregisterHandler(selectBookHandler);
                    });

                    $scope.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;
                    $scope.dateToString = DateService.dateToString;
                }

                $scope.closeBookDetailPanel = function () {
                    $scope.bookDetailPanelOpen = false;
                };

                init();
            }]
        };
    });