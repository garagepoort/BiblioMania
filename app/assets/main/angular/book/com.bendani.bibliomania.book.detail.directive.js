angular
    .module('com.bendani.bibliomania.book.detail.directive', ['com.bendani.bibliomania.book.model',
        'com.bendani.bibliomania.book.overview.service',
        'com.bendani.bibliomania.personal.book.info.detail.directive',
        'com.bendani.bibliomania.currency.service'])
    .directive('bookDetail', function (){
        return {
            scope: {},
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-directive.html",
            controller: ['$scope', 'BookOverviewService', 'DateService', 'Book', 'CurrencyService', 'ErrorContainer', function($scope, BookOverviewService, DateService, Book, CurrencyService, ErrorContainer){
                var vm = this;
                vm.closeBookDetailPanel = closeBookDetailPanel;

                var selectBookHandler = function (book) {
                    if (vm.bookDetailPanelOpen && vm.selectedBook.id === book.id) {
                        vm.bookDetailPanelOpen = false;
                    } else {
                        vm.selectedBook = Book.get({id: book.id}, function () {}, ErrorContainer.handleRestError);
                        vm.bookDetailPanelOpen = true;
                    }
                };

                function init(){
                    BookOverviewService.registerHandler(selectBookHandler);
                    $scope.$on('$destroy', function () {
                        BookOverviewService.deregisterHandler(selectBookHandler);
                    });

                    vm.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;
                    vm.dateToString = DateService.dateToString;
                }

                function closeBookDetailPanel() {
                    vm.bookDetailPanelOpen = false;
                }

                init();
            }],
            controllerAs: 'vm'
        };
    });