angular
    .module('com.bendani.bibliomania.chart.directive', ['com.bendani.bibliomania.chart.data.model'])
    .directive('chart', function (){
        return {
            scope: {
                chartConfigurationId: "="
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/statistics/chart.html",
            controller: ['$scope', '$location', 'ChartData', 'ErrorContainer', function($scope, $location, ChartData, ErrorContainer){

                function init(){
                    $scope.chartData = ChartData.get({ id: $scope.chartConfigurationId }, function(){}, ErrorContainer.handleRestError);
                }

                $scope.editChart = function(){
                    $location.path('/edit-chart/' + $scope.chartConfigurationId);
                };

                $scope.getColumnClass = function(){
                    if($scope.chartData.labels.length <= 16){
                        return 'col-md-6';
                    }
                    return 'col-md-12';
                };

                init();
            }]
        };
    });