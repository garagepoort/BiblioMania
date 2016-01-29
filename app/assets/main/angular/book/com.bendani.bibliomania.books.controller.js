'use strict';

angular.module('com.bendani.bibliomania.book.controller', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.book.filter.model',
    'com.bendani.php.common.filterservice',
    'com.bendani.bibliomania.book.overview.service',
    'com.bendani.bibliomania.image.card.directive',
    'com.bendani.bibliomania.book.row.directive',
    'com.bendani.bibliomania.currency.service',
    'com.bendani.bibliomania.book.detail.directive',
    'pageslide-directive'])
    .controller('BookController', ['$scope', 'Book', 'BookFilter', 'ErrorContainer', 'TitlePanelService', '$location', '$compile', 'BookOverviewService', 'CurrencyService', 'DateService', 'ScrollingService', '$timeout', 'FilterService',
        function ($scope, Book, BookFilter, ErrorContainer, TitlePanelService, $location, $compile, BookOverviewService, CurrencyService, DateService, ScrollingService, $timeout, FilterService) {
            var personalBooks = {key: 'Mijn boeken in collectie', value: 'personalBooks', searchBooks: Book.searchMyBooks};
            var personalBooksNotInCollection = {key: 'Mijn boeken niet in collectie', value: 'personalBooksNotInCollection', searchBooks: Book.searchMyBooks};
            var allBooks = {key: 'Alle boeken', value: 'all', searchBooks: Book.searchAllBooks};
            var otherBooks = {key: 'Andere boeken', value: 'otherBooks', searchBooks: Book.searchOtherBooks};
            var wishlist = {key: 'Wishlist', value: 'wishlist', searchBooks: Book.searchWishlist};

            function init() {
                TitlePanelService.setTitle('Boeken');
                TitlePanelService.setShowPreviousButton(false);
                setRightTitlePanel();

                $scope.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;
                $scope.dateToString = DateService.dateToString;

                $scope.libraryInformationTemplate = '../BiblioMania/views/partials/book/library-information-template.html';
                $scope.filterViewableBooksTemplate = '../BiblioMania/views/partials/book/filter-viewable-books-template.html';

                $scope.loading = true;
                $scope.searchBooksQuery = "";
                $scope.predicate = "mainAuthor";
                $scope.reverseOrder = false;
                $scope.setListView(false);

                $scope.viewableFilters = { selected: personalBooks, all: [allBooks, otherBooks, personalBooks, personalBooksNotInCollection, wishlist] };

                $scope.selectViewableFilter = function(){
                    FilterService.filter($scope.filterBooks);
                };

                $scope.$watch('viewableBooks', function(){
                    if($scope.viewableBooks){
                        updateLibraryInformation($scope.viewableBooks);
                    }
                });

                getFilters();
                FilterService.filter($scope.filterBooks);
            }

            $scope.search = function (item) {
                if(item.subtitle === undefined || item.subtitle === null){
                    item.subtitle = "";
                }

                if ((item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                    || (item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                    || (item.mainAuthor.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)) {

                    if($scope.viewableFilters.selected === personalBooks){
                        return item.inCollection;
                    }

                    if($scope.viewableFilters.selected === personalBooksNotInCollection){
                        return !item.inCollection;
                    }

                    return true;
                }
                return false;
            };

            $scope.setListView = function (value) {
                $scope.listView = value;

                if ($scope.listView) {
                    $scope.orderValues = [
                        {key: 'Titel', predicate: 'title', width: '30'},
                        {key: 'Ondertitel', predicate: 'subtitle', width: '30'},
                        {key: 'Auteur', predicate: 'mainAuthor', width: '30'},
                        {key: 'Gelezen', predicate: 'read', width: '30'},
                        {key: 'Editeer', predicate: '', width: '10'}
                    ];
                } else {
                    $scope.orderValues = [
                        {key: 'Titel', predicate: 'title', width: '50'},
                        {key: 'Auteur', predicate: 'mainAuthor', width: '50'}
                    ];
                }
            };

            $scope.filterBooks = function (selectedFilters) {
                $scope.loading = true;
                $scope.viewableFilters.selected.searchBooks(selectedFilters, function (books) {
                    onBooksSearched(books);
                }, ErrorContainer.handleRestError);
            };

            $scope.goToCreateBook = function () {
                $location.path('/create-book');
            };

            $scope.onImageClickBook = function(book){
                BookOverviewService.selectBook(book);
            };

            $scope.onEditBook = function(book){
                $location.path('/book-details/' + book.id);
            };

            function setRightTitlePanel() {
                var titlePanelRight = angular.element('<button class="btn btn-success no-round-corners" ng-click="goToCreateBook()">Nieuw boek</button>');
                $compile(titlePanelRight)($scope);
                TitlePanelService.setRightPanel(titlePanelRight);
            }

            function getFilters() {
                BookFilter.query(function (filters) {
                    for (var i = 0; i < filters.length; i++) {
                        var filter = filters[i];
                        if (filter.supportedOperators) {
                            filter.selectedOperator = filter.supportedOperators[0];
                        }
                        filter.value = "";
                    }
                    FilterService.setAllFilters(filters);
                }, ErrorContainer.handleRestError);
            }

            function onBooksSearched(books) {
                $scope.books = books;
                _.each($scope.books, function (book) {
                    book.warnings = BookOverviewService.getBookWarnings(book);
                });
                scrollToLastPosition();
                $scope.loading = false;
            }

            function updateLibraryInformation(books){
                $scope.libraryInformation = {
                    value: calculateLibraryValue(books),
                    amountOfBooks: books.length
                };
            }

            function calculateLibraryValue(books) {
                var result = 0;
                _.each(books, function (book) {
                    if (book.retailPrice && book.retailPrice.amount) {
                        result = result + parseFloat(book.retailPrice.amount);
                    }
                });
                return result.toFixed(2);
            }

            function scrollToLastPosition() {
                $timeout(function () {
                    ScrollingService.scrollToLastSavedPosition('/books');
                }, 0);
            }

            init();
        }]);