angular
    .module('com.bendani.bibliomania.book.detail.directive', ['com.bendani.bibliomania.book.model',
        'com.bendani.bibliomania.book.overview.service',
        'com.bendani.bibliomania.personal.book.info.detail.directive',
        'com.bendani.bibliomania.currency'])
    .directive('bookDetail', function (){
        return {
            scope: {},
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-directive.html",
            controller: ['$scope', '$location', 'BookOverviewService', 'Book', 'CurrencyService', 'ErrorContainer', function($scope, $location, BookOverviewService, Book, CurrencyService, ErrorContainer){
                var vm = this;
                vm.closeBookDetailPanel = closeBookDetailPanel;
                vm.goToEditBook = goToEditBook;

                var selectBookHandler = function (book) {
                    if (vm.bookDetailPanelOpen && vm.selectedBook.id === book.id) {
                        vm.bookDetailPanelOpen = false;
                    } else {
                        vm.loading = true;
                        Book.get({id: book.id}).$promise.then(function (book) {
                            vm.selectedBook = book;
                            vm.loading = false;
                        }).catch(ErrorContainer.handleRestError);
                        vm.bookDetailPanelOpen = true;
                    }
                };

                function init(){
                    BookOverviewService.registerHandler(selectBookHandler);
                    $scope.$on('$destroy', function () {
                        BookOverviewService.deregisterHandler(selectBookHandler);
                    });

                    vm.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;
                }

                function closeBookDetailPanel() {
                    vm.bookDetailPanelOpen = false;
                }

                function goToEditBook(){
                    $location.path('/book-details/' + vm.selectedBook.id);
                }

                init();
            }],
            controllerAs: 'vm'
        };
    });