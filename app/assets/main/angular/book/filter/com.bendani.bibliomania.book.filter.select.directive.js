angular
    .module('com.bendani.bibliomania.book.filter.select.directive', ['com.bendani.bibliomania.book.filter.model', 'com.bendani.bibliomania.error.container'])
    .directive('bookFilterSelect', function (){
        return {
            scope: {
                selectedFilters: "=selectedFilters"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-select.html",
            controller: ['$scope', 'BookFilter', 'ErrorContainer',function($scope, BookFilter, ErrorContainer) {

                function init() {
                    $scope.allFilters = {};

                    getFilters();
                }

                $scope.selectFilter = function selectFilter($event, filter){
                    var checkbox = $event.target;
                    if(checkbox.checked){
                        $scope.selectedFilters.push(filter);
                    }else{
                        var index = $scope.selectedFilters.indexOf(filter);
                        $scope.selectedFilters.splice(index, 1);
                    }
                };

                function getFilters() {
                    BookFilter.query(function(filters){
                        for(var i = 0; i< filters.length; i++){
                            var filter = filters[i];
                            filter.selectedOperator = filter.supportedOperators[0].value;
                            filter.value = "";
                            if ($scope.allFilters[filter.group] === undefined){
                                $scope.allFilters[filter.group] = [];
                            }
                            $scope.allFilters[filter.group].push(filter);
                        }
                    }, ErrorContainer.handleRestError);
                }

                init();
            }]
        };
    });