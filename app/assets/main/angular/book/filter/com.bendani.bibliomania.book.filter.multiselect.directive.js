angular
    .module('com.bendani.bibliomania.book.filter.multiselect.directive', [])
    .directive('bookFilterMultiselect', function (){
        return {
            scope: {
                filter: "=filter"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-multiselect.html",
            controller: ['$scope', '$compile', function($scope, $compile) {
                $scope.filter.value = "";
                $scope.filter.selectedOperator = $scope.filter.supportedOperators[0];

                $scope.shouldShowOperators = function(){
                    return $scope.filter.supportedOperators.length > 1;
                }
            }],
            link: function($scope, $elem){
                $elem.find(".filterinput").multiselect({
                    enableFiltering: true
                });
            }
        };
    });