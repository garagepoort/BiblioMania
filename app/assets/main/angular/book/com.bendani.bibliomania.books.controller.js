'use strict';

angular.module('com.bendani.bibliomania.book.controller', ['com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.book.filter.model',
    'com.bendani.php.common.filterservice',
    'pageslide-directive'])
    .controller('BookController', ['$scope', 'Book', 'BookFilter', 'ErrorContainer', '$http', 'TitlePanelService', '$location', '$compile', function ($scope, Book, BookFilter, ErrorContainer, $http, TitlePanelService, $location, $compile) {

        function init(){
            TitlePanelService.setTitle('Boeken');
            TitlePanelService.setShowPreviousButton(false);
            setRightTitlePanel();
            $scope.searchBooksQuery = "";
            $scope.loading=true;
            $scope.predicate="author";
            $scope.reverseOrder=false;
            $scope.libraryInformation= {};
            $scope.showAllBooks = false;
            $scope.bookDetailPanelOpen = false;
            $scope.libraryInformationTemplate = '../BiblioMania/views/partials/book/library-information-template.html';

            $scope.filters = {
                selected: [],
                all: []
            };

            $scope.libraryInformation = {
                value: 0,
                amountOfBooks: 0
            };

            getFilters();
            $scope.filterBooks([]);

            $scope.orderValues = [
                { key: 'Titel', predicate:'title'},
                { key: 'Ondertitel', predicate:'subtitle'},
                { key: 'Auteur', predicate:'author'},
                { key: 'Waardering', predicate:'rating'}
            ];
        }

        $scope.closeBookDetailPanel = function(){
            $scope.bookDetailPanelOpen = false;
        };

        $scope.openBookDetailPanel = function(){
            $scope.bookDetailPanelOpen = true;
        };

        $scope.isBookDetailPanelOpen = function(){
            return $scope.bookDetailPanelOpen;
        };

        $scope.setSelectedBook = function(selectBookId){
            $scope.selectedBook = Book.get({id: selectBookId}, function(){}, ErrorContainer.handleRestError);
            $scope.openBookDetailPanel();
        };

        $scope.search = function(item){
            if ( (item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                || (item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                || (item.author.toLowerCase().indexOf($scope.searchBooksQuery) !== -1) ){
                return true;
            }
            return false;
        };

        $scope.getSelectedBook = function(){
            return $scope.selectedBook;
        };

        $scope.resetBooks = function(){
            $scope.filterBooks([]);
        };

        $scope.filterBooks = function(filters){
            $scope.loading = true;

            if(!$scope.showAllBooks){
                filters.push({
                    id: 'isPersonal',
                    value: true,
                    operator: '='
                });
            }

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
                        filter.selectedOperator = filter.supportedOperators[0].value;
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