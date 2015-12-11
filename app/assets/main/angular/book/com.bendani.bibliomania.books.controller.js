'use strict';

angular.module('com.bendani.bibliomania.book.controller', ['com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.title.panel'])
    .controller('BookController', ['$scope', 'Book', 'ErrorContainer', '$http', 'TitlePanelService',function ($scope, Book, ErrorContainer, $http, TitlePanelService) {

        function init(){
            TitlePanelService.setTitle('Boeken');
            TitlePanelService.setShowPreviousButton(false);
            $scope.searchBooksQuery = "";
            $scope.loading=true;
            $scope.predicate="author";
            $scope.reverseOrder=false;
            $scope.libraryInformation= {};
            $scope.showAllBooks = false;

            $scope.bookModel = {
                selectedBookId:null,
                bookDetailPanelOpen:false
            };

            $scope.filterBooks([]);

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
            if ( (item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                || (item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)
                || (item.author.toLowerCase().indexOf($scope.searchBooksQuery) !== -1) ){
                return true;
            }
            return false;
        };

        $scope.getSelectedBookId = function(){
            return $scope.bookModel.selectedBookId;
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
            }, ErrorContainer.handleRestError);
        };

        init();
    }]);