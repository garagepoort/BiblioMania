angular
    .module('com.bendani.bibliomania.book.filter.boolean.directive', [])
    .directive('bookFilterBoolean', function (){
        return {
            scope: {
                filter: "=filter"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-boolean.html",
            controller: ['$scope', '$compile', function($scope, $compile) {
                $scope.filter.value = false;
            }],
            link: function($scope, $elem){
                $elem.find(".filterInput").bootstrapSwitch({
                    size: "small",
                    onText: "Ja",
                    offText: "Nee",
                });
            }
        };
    });