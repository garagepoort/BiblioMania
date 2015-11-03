'use strict';

angular.module('com.bendani.bibliomania.book.controller', ['com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.error.container'])
    .controller('BookController', ['$scope', 'Book', 'ErrorContainer',function ($scope, Book, ErrorContainer) {

        function init(){
            $scope.searchBooksQuery = "";

            $scope.bookModel = {
                selectedBookId:null,
                bookDetailPanelOpen:false
            };

            Book.get(function (books) {
                retrieveBooks(books);
            }, ErrorContainer.handleRestError);

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
        }

        $scope.openBookDetailPanel = function(){
            $scope.bookModel.bookDetailPanelOpen = true;
            $scope.$apply();
        }

        $scope.isBookDetailPanelOpen = function(){
            return $scope.bookModel.bookDetailPanelOpen;
        }

        $scope.setSelectedBookId = function(selectBookId){
            $scope.bookModel.selectedBookId = selectBookId;
            $scope.$apply();
        }

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
        }

        function retrieveBooks(books) {
            $scope.books = books.data;
            fillInBookContainer(books.data);
        }

        function fillInBookContainer(books) {
            $scope.bookCollection = [];

            var amountBooks = Object.keys(books).length;

            for (var i = 0; i < amountBooks / 6; i++) {
                var columns = 6;
                if (i * 6 + 6 > amountBooks) {
                    columns = amountBooks % 6;
                }

                var bookRow = { books: [] };
                for (var j = 0; j < columns; j++) {
                    var book = books[(6 * i) + j];
                    bookRow.books.push(book);
                }
                $scope.bookCollection.push(bookRow);
            }
        }
        init();
    }]);