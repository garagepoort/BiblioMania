angular
    .module('com.bendani.bibliomania.chart.directive', ['com.bendani.bibliomania.chart.data.model'])
    .directive('chart', function (){
        return {
            scope: {
                chartConfigurationId: "="
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/statistics/chart.html",
            controller: ['$scope', 'ChartData', 'ErrorContainer', function($scope, ChartData, ErrorContainer){

                function init(){
                    $scope.chartData = ChartData.get({ id: $scope.chartConfigurationId }, function(){}, ErrorContainer.handleRestError);

                }
                init();
            }]
        };
    });