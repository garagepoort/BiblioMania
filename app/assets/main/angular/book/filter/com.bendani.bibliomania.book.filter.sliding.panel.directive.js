angular
    .module('com.bendani.bibliomania.book.filter.sliding.panel.directive', ['com.bendani.bibliomania.error.container'])
    .directive('bookFilterSlidingPanel', function (){
        return {
            scope: true,
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-sliding-panel.html",
            controller: ['$scope', '$compile', '$http', 'ErrorContainer', function($scope, $compile, $http, ErrorContainer) {
                var filterPanelOpen  = false;
                var message;

                function init(){
                    $scope.filters = {
                        selected: []
                    };
                    message = $compile("<book-filter-select selected-filters='filters.selected'></book-filter-select>")($scope);

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
                    BootstrapDialog.show({
                        title: "Selecteer filters",
                        closable: true,
                        message: $(message),
                        buttons: [
                            {
                                icon: "fa fa-times-circle",
                                label: 'Sluiten',
                                cssClass: 'btn-default',
                                action: function (dialogItself) {
                                    dialogItself.close();
                                }
                            }]
                    });
                };

                $scope.filterBooks = function() {
                    $http.post("../BiblioMania/books/search", convertFiltersToJson()).then(function(bookData){
                        $scope.$parent.fillInBookContainer(bookData.data.data);
                    }, ErrorContainer.handleRestError);
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

                init();
            }]
        };
    });