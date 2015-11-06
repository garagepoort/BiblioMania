angular
    .module('com.bendani.bibliomania.book.filter.select.directive', [])
    .directive('bookFilterSelect', function (){
        return {
            scope: {
                filters: "=filters"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-select.html",
            controller: ['$scope', 'BookFilter', 'ErrorContainer',function($scope) {

                $scope.selectFilter = function selectFilter($event, filter){
                    var checkbox = $event.target;
                    if(checkbox.checked){
                        $scope.filters.selected.push(filter);
                    }else{
                        var index = $scope.filters.selected.indexOf(filter);
                        $scope.filters.selected.splice(index, 1);
                    }
                };

                $scope.getAllBookFilters = function(){
                    return $scope.filters.all.filter(function(element){
                        return element.group === 'book';
                    });
                };

                $scope.getAllPersonalFilters = function(){
                    return $scope.filters.all.filter(function(element){
                        return element.group === 'personal';
                    });
                };

                $scope.getAllBuyGiftFilters = function(){
                    return $scope.filters.all.filter(function(element){
                        return element.group === 'buy-gift';
                    });
                };
            }]
        };
    });