angular.module('com.bendani.bibliomania.book.selection.controller', ['com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.error.container'])
    .controller('BookSelectionController', ['$scope', 'Book', 'ErrorContainer', function($scope, Book, ErrorContainer){

        function init(){
            $scope.data = {};
            $scope.data.books = Book.query(function(){}, ErrorContainer.handleRestError);
            $scope.searchBooksQuery = '';
        }

        $scope.selectBook = function(book){
            $scope.$close(book);
        };

        $scope.search = function(item){
            if ((item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)){
                return true;
            }
            return false;
        };

        init();
    }]);