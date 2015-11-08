angular
    .module('com.bendani.bibliomania.book.filter.sliding.panel.directive', ['com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.filter.model', 'com.bendani.php.common.filterservice'])
    .directive('bookFilterSlidingPanel', function (){
        return {
            scope: true,
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-sliding-panel.html",
            controller: ['$scope', '$compile', '$http', 'ErrorContainer', 'BookFilter', '$uibModal', function($scope, $compile, $http, ErrorContainer, BookFilter, $uibModal) {
                var filterPanelOpen  = false;

                function init(){
                    $scope.filters = {
                        selected: [],
                        all: []
                    };

                    getFilters();

                    var slidingPanel = new BorderSlidingPanel($('#libraryFilterSlidingPanel'), "left", 10);
                    $('#libraryFilterBookMark').on('click', function () {
                        if (filterPanelOpen) {
                            slidingPanel.close(function () {
                                filterPanelOpen = false;
                            });
                        } else {
                            slidingPanel.open(function () {
                                filterPanelOpen = true;
                            });
                        }
                    });

                }

                 $scope.showSelectFiltersDialog = function () {
                    $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/book/book-filter-select-modal.html',
                        scope: $scope
                    });
                };

                $scope.doFilterBooks = function() {
                    $scope.$parent.filterBooks(convertFiltersToJson());
                };

                $scope.resetBookFilter = function(){
                    $scope.filters.selected = [];
                    $scope.$parent.resetBooks();
                };

                function convertFiltersToJson(){
                    var filters = [];
                    for (var filter in  $scope.filters.selected) {
                        var filterObject = $scope.filters.selected[filter];
                        filters.push({
                            id: filterObject.id,
                            value: filterObject.value,
                            operator: filterObject.selectedOperator
                        });
                    }
                    return filters;
                }

                function getFilters() {
                    BookFilter.query(function(filters){
                        for(var i = 0; i< filters.length; i++){
                            var filter = filters[i];
                            filter.selectedOperator = filter.supportedOperators[0].value;
                            filter.value = "";
                        }
                        $scope.filters.all = filters;
                    }, ErrorContainer.handleRestError);
                }

                init();
            }]
        };
    });