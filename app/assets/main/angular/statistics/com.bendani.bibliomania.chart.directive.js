angular
    .module('com.bendani.bibliomania.chart.directive', ['com.bendani.bibliomania.chart.data.model', 'com.bendani.bibliomania.confirmation.modal.service', 'com.bendani.bibliomania.chart.configuration.model'])
    .directive('chart', function (){
        return {
            scope: {
                chartConfigurationId: "=",
                onDelete: '&'
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/statistics/chart.html",
            controller: ['$scope', '$location', 'ChartData', 'ErrorContainer', 'ConfirmationModalService', 'ChartConfiguration', 'growl', function($scope, $location, ChartData, ErrorContainer, ConfirmationModalService, ChartConfiguration, growl){

                function init(){
                    $scope.chartData = ChartData.get({ id: $scope.chartConfigurationId }, function(){
                        $scope.series = [$scope.chartData.xLabel];
                    }, ErrorContainer.handleRestError);
                }

                $scope.editChart = function(){
                    $location.path('/edit-chart/' + $scope.chartConfigurationId);
                };

                $scope.deleteChart = function(){
                    ConfirmationModalService.show('Bent je zeker dat je dit diagram wilt verwijderen?', function () {
                        ChartConfiguration.delete({ id: $scope.chartConfigurationId }, function(){
                            growl.addSuccessMessage('Diagram verwijdert');
                            $scope.onDelete();
                        }, ErrorContainer.handleRestError);
                    });
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