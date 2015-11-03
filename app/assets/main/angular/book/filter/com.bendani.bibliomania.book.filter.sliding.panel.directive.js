angular
    .module('com.bendani.bibliomania.book.filter.sliding.panel.directive', [])
    .directive('bookFilterSlidingPanel', function (){
        return {
            scope: true,
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-filter-sliding-panel.html",
            controller: ['$scope', '$compile', function($scope, $compile) {
                var filterPanelOpen  = false;

                function init(){
                    $scope.filters = {
                        selected: []
                    };

                    var message = $compile("<book-filter-select selected-filters='filters.selected'></book-filter-select>")($scope);
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

                    $scope.doFilterBooks = function(filters) {
                        var url = window.baseUrl + "/filterBooks?";
                        var params = {
                            filter: filters
                        };
                        url = url + jQuery.param(params);

                        $('#books-container-table > tbody').empty();
                        abortLoadingPaged();
                        startLoadingPaged(url, 1, fillInBookContainer);
                    };


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

                init();
            }]
        };
    });