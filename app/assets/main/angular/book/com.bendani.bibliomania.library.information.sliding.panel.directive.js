angular
    .module('com.bendani.bibliomania.library.information.sliding.panel.directive', [])
    .directive('libraryInformationSlidingPanel', function (){
        return {
            scope: {
                information: "="
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/library-information-sliding-panel.html",
            controller: ['$scope', function($scope) {
                var infoPanelOpen = false;

                function init(){
                    var slidingPanel = new BorderSlidingPanel($('#libraryInformationSlidingPanel'), "left", 10);

                    $('#libraryInformationSlidingPanel').on('click', function () {
                        if (infoPanelOpen) {
                            slidingPanel.close(function () {
                                infoPanelOpen = false;
                            });
                        } else {
                            slidingPanel.open(function () {
                                infoPanelOpen = true;
                            });
                        }
                    });
                }

                init();
            }]
        };
    });