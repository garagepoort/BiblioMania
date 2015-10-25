'use strict';

angular.module('com.bendani.bibliomania.book.controller', ['com.bendani.bibliomania.book.model'])
    .controller('BookController', ['$scope', 'Book', function ($scope, Book) {


        function init(){
            $scope.bookModel = {selectedBookId:null};
            Book.get(function (books) {
                retrieveBooks(books);
            }, function(data){
                $scope.error = data;
            });

            $scope.orderValues = [
                { key: 'Auteur', value:'author'},
                { key: 'Titel', value:'title'},
                { key: 'Ondertitel', value:'subtitle'},
                { key: 'Waardering', value:'rating'}
            ];
        }

        $scope.setSelectedBookId = function(selectBookId){
            $scope.bookModel.selectedBookId = selectBookId;
            $scope.$apply();
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