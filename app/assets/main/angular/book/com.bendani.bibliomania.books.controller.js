'use strict';

angular.module('com.bendani.bibliomania.book.controller', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.book.filter.model',
    'com.bendani.php.common.filterservice',
    'com.bendani.bibliomania.book.overview.service',
    'com.bendani.bibliomania.book.card.directive',
    'com.bendani.bibliomania.book.row.directive',
    'com.bendani.bibliomania.currency.service',
    'pageslide-directive'])
    .controller('BookController', ['$scope', 'Book', 'BookFilter', 'ErrorContainer', '$http', 'TitlePanelService', '$location', '$compile', 'BookOverviewService', 'CurrencyService', 'DateService',
        function ($scope, Book, BookFilter, ErrorContainer, $http, TitlePanelService, $location, $compile, BookOverviewService, CurrencyService, DateService) {

            var selectBookHandler = function (book) {
                if ($scope.bookDetailPanelOpen && $scope.selectedBook.id === book.id) {
                    $scope.bookDetailPanelOpen = false;
                } else {
                    $scope.selectedBook = Book.get({id: book.id}, function () {
                    }, ErrorContainer.handleRestError);
                    $scope.bookDetailPanelOpen = true;
                }
            };

            var personalBooks = {key: 'Mijn boeken', value: 'personalBooks'};
            var allBooks = {key: 'Alle boeken', value: 'all'};
            var otherBooks = {key: 'Andere boeken', value: 'otherBooks'};

            function init() {
                TitlePanelService.setTitle('Boeken');
                TitlePanelService.setShowPreviousButton(false);
                setRightTitlePanel();

                $scope.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;
                $scope.dateToString = DateService.dateToString;

                $scope.searchBooksQuery = "";
                $scope.loading = true;
                $scope.predicate = "author";
                $scope.reverseOrder = false;
                $scope.bookDetailPanelOpen = false;
                $scope.libraryInformationTemplate = '../BiblioMania/views/partials/book/library-information-template.html';
                $scope.filterViewableBooksTemplate = '../BiblioMania/views/partials/book/filter-viewable-books-template.html';
                $scope.setListView(false);


                $scope.filters = {selected: [], all: []};

                $scope.viewableFilters = {
                    selected: personalBooks,
                    all: [allBooks, otherBooks, personalBooks]
                };

                $scope.$watch('viewableBooks', function(){
                    if($scope.viewableBooks){
                        updateLibraryInformation($scope.viewableBooks);
                    }
                });

                getFilters();
                $scope.filterBooks([]);

                BookOverviewService.registerHandler(selectBookHandler);
                $scope.$on('$destroy', function () {
                    BookOverviewService.deregisterHandler(selectBookHandler);
                });
            }

            $scope.closeBookDetailPanel = function () {
                $scope.bookDetailPanelOpen = false;
            };

            $scope.search = function (item) {
                if ($scope.viewableFilters.selected === personalBooks && !item.personalBookInfoId) {
                    return false;
                }
                if ($scope.viewableFilters.selected === otherBooks && item.personalBookInfoId) {
                    return false;
                }

                if ((item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                    || (item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                    || (item.author.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)) {
                    return true;
                }
                return false;
            };

            $scope.resetBooks = function () {
                $scope.filterBooks([]);
            };

            $scope.setListView = function (value) {
                $scope.listView = value;

                if ($scope.listView) {
                    $scope.orderValues = [
                        {key: 'Titel', predicate: 'title', width: '30'},
                        {key: 'Auteur', predicate: 'author', width: '30'},
                        {key: 'Gelezen', predicate: 'read', width: '30'},
                        {key: 'Editeer', predicate: '', width: '10'}
                    ];
                } else {
                    $scope.orderValues = [
                        {key: 'Titel', predicate: 'title', width: '50'},
                        {key: 'Auteur', predicate: 'author', width: '50'}
                    ];
                }
            };

            $scope.filterBooks = function (filters) {
                $scope.loading = true;

                Book.search(filters, function (books) {
                    $scope.books = books;
                    $scope.loading = false;
                }, ErrorContainer.handleRestError);
            };

            $scope.goToCreateBook = function () {
                $location.path('/create-book');
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
                    filters = filters.filter(function (obj) {
                        return obj.id !== 'isPersonal';
                    });
                    $scope.filters.all = filters;
                }, ErrorContainer.handleRestError);
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
                    if (book.retailPrice) {
                        result = result + book.retailPrice.amount;
                    }
                });
                return result.toFixed(2);
            }

            init();
        }]);