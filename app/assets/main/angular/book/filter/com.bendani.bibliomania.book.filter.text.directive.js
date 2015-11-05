angular
    .module('com.bendani.bibliomania.book.filter.text.directive', [])
    .directive('bookFilterText', function (){
        return {
            scope: {
                filter: "=filter"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-text.html",
            controller: ['$scope', '$compile', function($scope, $compile) {
                $scope.filter.value = "";
                $scope.filter.selectedOperator = $scope.filter.supportedOperators[0];
            }],
            link: function($scope, $elem){
            }
        };
    });