angular.module('com.bendani.bibliomania.date.selection.controller', ['com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.error.container'])
    .controller('DateSelectionController', ['$scope', 'Book', 'ErrorContainer', function($scope, Book, ErrorContainer){

        function init(){
            $scope.model = {};
            $scope.model.readingDate = new Date();
        }

        $scope.selectDate = function(){
            $scope.$close($scope.model.readingDate);
        };

        init();
    }]);