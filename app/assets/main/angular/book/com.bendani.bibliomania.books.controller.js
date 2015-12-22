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
    .controller('BookController', ['$scope', 'Book', 'BookFilter', 'ErrorContainer', '$http', 'TitlePanelService', '$location', '$compile', 'BookOverviewService', 'CurrencyService', function ($scope, Book, BookFilter, ErrorContainer, $http, TitlePanelService, $location, $compile, BookOverviewService, CurrencyService) {

        var selectBookHandler = function (book) {
            if($scope.bookDetailPanelOpen && $scope.selectedBook.id === book.id){
                $scope.bookDetailPanelOpen = false;
            }else{
                $scope.selectedBook = Book.get({id: book.id}, function(){}, ErrorContainer.handleRestError);
                $scope.bookDetailPanelOpen = true;
            }
        };

        var personalBooks = {key: 'Mijn boeken', value: 'personalBooks'};
        var allBooks = {key: 'Alle boeken', value: 'all'};
        var otherBooks = {key: 'Andere boeken', value: 'otherBooks'};

        function init(){
            TitlePanelService.setTitle('Boeken');
            TitlePanelService.setShowPreviousButton(false);
            setRightTitlePanel();

            $scope.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;

            $scope.searchBooksQuery = "";
            $scope.loading=true;

            $scope.predicate="author";
            $scope.reverseOrder=false;
            $scope.libraryInformationTemplate = '../BiblioMania/views/partials/book/library-information-template.html';
            $scope.filterViewableBooksTemplate = '../BiblioMania/views/partials/book/filter-viewable-books-template.html';

            $scope.bookDetailPanelOpen = false;

            $scope.filters = {selected: [],all: []};

            $scope.viewableFilters = {
                selected: personalBooks,
                all: [allBooks,otherBooks,personalBooks]
            };

            $scope.libraryInformation = {value: 0, amountOfBooks: 0 };

            $scope.setListView(false);
            getFilters();
            $scope.filterBooks([]);

            BookOverviewService.registerHandler(selectBookHandler);
            $scope.$on('$destroy', function() {
                BookOverviewService.deregisterHandler(selectBookHandler);
            });
        }

        $scope.closeBookDetailPanel = function(){
            $scope.bookDetailPanelOpen = false;
        };

        $scope.search = function(item){
            if($scope.viewableFilters.selected === personalBooks && !item.personalBookInfoId){
                return false;
            }
            if($scope.viewableFilters.selected === otherBooks && item.personalBookInfoId){
                return false;
            }

            if ( (item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                || (item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                || (item.author.toLowerCase().indexOf($scope.searchBooksQuery) !== -1) ){
                return true;
            }
            return false;
        };

        $scope.resetBooks = function(){
            $scope.filterBooks([]);
        };

        $scope.setListView = function(value){
            $scope.listView = value;

            if($scope.listView){
                $scope.orderValues = [
                    { key: 'Titel', predicate:'title'},
                    { key: 'Ondertitel', predicate:'subtitle'},
                    { key: 'Auteur', predicate:'author'},
                    { key: 'Gelezen', predicate:'read'}
                ];
            }else{
                $scope.orderValues = [
                    { key: 'Titel', predicate:'title'},
                    { key: 'Ondertitel', predicate:'subtitle'},
                    { key: 'Auteur', predicate:'author'}
                ];
            }
        };

        $scope.filterBooks = function(filters){
            $scope.loading = true;

            Book.search(filters, function(books){
                $scope.books = books;
                $scope.loading = false;

                $scope.libraryInformation.amountOfBooks = books.length;
                $scope.libraryInformation.value = 0;


                _.each(books, function(book){
                    if(book.retailPrice){
                        $scope.libraryInformation.value = $scope.libraryInformation.value + book.retailPrice.amount;
                    }
                    $scope.libraryInformation.value = +$scope.libraryInformation.value.toFixed(2);
                });

            }, ErrorContainer.handleRestError);
        };

        $scope.goToCreateBook = function(){
            $location.path('/create-book');
        };

        function setRightTitlePanel(){
            var titlePanelRight = angular.element('<button class="btn btn-success no-round-corners" ng-click="goToCreateBook()">Nieuw boek</button>');
            $compile(titlePanelRight)($scope);
            TitlePanelService.setRightPanel(titlePanelRight);
        }

        function getFilters() {
            BookFilter.query(function(filters){
                for(var i = 0; i< filters.length; i++){
                    var filter = filters[i];
                    if(filter.supportedOperators){
                        filter.selectedOperator = filter.supportedOperators[0];
                    }
                    filter.value = "";
                }
                filters = filters.filter(function( obj ) {
                    return obj.id !== 'isPersonal';
                });
                $scope.filters.all = filters;
            }, ErrorContainer.handleRestError);
        }

        init();
    }]);