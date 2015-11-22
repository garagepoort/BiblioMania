'use strict';

angular.module('com.bendani.bibliomania.book.controller', ['com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.error.container'])
    .controller('BookController', ['$scope', 'Book', 'ErrorContainer', '$http',function ($scope, Book, ErrorContainer, $http) {

        function retrieveAllBooks() {
            $scope.loading=true;
            Book.get(function (books) {
                $scope.books = books.data;
                $scope.loading = false;
                $scope.libraryInformation = books.library_information;
            }, ErrorContainer.handleRestError);
        }

        function init(){
            $scope.$parent.title = 'Boeken';
            $scope.searchBooksQuery = "";
            $scope.loading=true;
            $scope.predicate="author";
            $scope.reverseOrder=false;
            $scope.libraryInformation= {};

            $scope.bookModel = {
                selectedBookId:null,
                bookDetailPanelOpen:false
            };

            retrieveAllBooks();

            $scope.orderValues = [
                { key: 'Auteur', value:'author'},
                { key: 'Titel', value:'title'},
                { key: 'Ondertitel', value:'subtitle'},
                { key: 'Waardering', value:'rating'}
            ];
        }

        $scope.closeBookDetailPanel = function(){
            $scope.bookModel.bookDetailPanelOpen = false;
            $scope.$apply();
        };

        $scope.openBookDetailPanel = function(){
            $scope.bookModel.bookDetailPanelOpen = true;
            $scope.$apply();
        };

        $scope.isBookDetailPanelOpen = function(){
            return $scope.bookModel.bookDetailPanelOpen;
        };

        $scope.setSelectedBookId = function(selectBookId){
            $scope.bookModel.selectedBookId = selectBookId;
            $scope.$apply();
        };

        $scope.order = function(ordering){
            $scope.predicate = ordering;
        };

        $scope.setReverse = function(reverse){
            $scope.reverseOrder = reverse;
        };

        $scope.search = function(item){
            if ( (item.title.toLowerCase().indexOf($scope.searchBooksQuery) != -1)
                || (item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) != -1)
                || (item.author.toLowerCase().indexOf($scope.searchBooksQuery) != -1) ){
                return true;
            }
            return false;
        };

        $scope.getSelectedBookId = function(){
            return $scope.bookModel.selectedBookId;
        };

        $scope.resetBooks = function(){
            retrieveAllBooks();
        };

        $scope.filterBooks = function(filters){
            $scope.loading = true;
            $http.post("../BiblioMania/books/search", filters).then(function(response){
                $scope.books = response.data.data
                $scope.loading = false;
                $scope.libraryInformation = response.data.library_information;
            }, ErrorContainer.handleRestError);
        };

        init();
    }]);