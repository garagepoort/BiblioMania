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
                    $scope.bookFilters = [];
                    $scope.personalFilters = [];
                    $scope.giftBuyFilters = [];

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
                }

                function fillFilterRepository(filters) {
                    for (var f in filters) {
                        var filter = filters[f];
                        var filterId = filter.id;
                        var filterGroup = filter.group;
                        var filterType = filter.type;
                        var filterField = filter.field;
                        var filterOperators = filter.supportedOperators;
                        var filterOptions = [];

                        if (filter.options != undefined) {
                            filterOptions = filter.options;
                        }

                        var filter = new Filter(filterId, filterGroup, filterType, filterField, filterOperators, filterOptions, function (filter, selected) {
                            if (selected) {
                                if (filter.id.startsWith("book-")) {
                                    $('#book-form-container').append(filter.getFilterValueInputElement());
                                }
                                if (filter.id.startsWith("personal-")) {
                                    $('#personal-form-container').append(filter.getFilterValueInputElement());
                                }
                                if (filter.id.startsWith("buy-gift-")) {
                                    $('#buy-gift-form-container').append(filter.getFilterValueInputElement());
                                }
                                $scope.allSelectedFilters.push(filter);
                            } else {
                                filter.removeFilterInputFromDom();
                                $scope.allSelectedFilters.remove(filter);
                            }
                        });
                    }
                }

                function getFilters() {
                    BookFilter.query(function(filters){
                        for(var i = 0; i< filters.length; i++){
                            var filter = filters[i];
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