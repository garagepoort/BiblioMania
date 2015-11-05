angular
    .module('com.bendani.bibliomania.book.filter.boolean.directive', [])
    .directive('bookFilterBoolean', function (){
        return {
            scope: {
                filter: "=filter"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-boolean.html",
            controller: ['$scope', function($scope) {
                $scope.filter.value = false;
            }]
        };
    });