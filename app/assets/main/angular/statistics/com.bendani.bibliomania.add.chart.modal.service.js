'use strict';

angular.module('com.bendani.bibliomania.add.chart.modal.service', [])
    .provider('AddChartModalService', function AddChartModalServiceProvider() {

        function AddChartModalService($uibModal) {
            var service = {
                show: function(onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/statistics/add-chart-modal.html',
                        controller: 'AddChartModalController'
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new AddChartModalService($uibModal);
        }];
    })
    .controller('AddChartModalController', ['$scope', 'ChartConfiguration', 'ErrorContainer', 'growl', function($scope, ChartConfiguration, ErrorContainer, growl){

        $scope.submitAttempted = false;
        $scope.model = {};
        $scope.model.conditions = [];

        $scope.data = {};
        $scope.data.xproperties = ChartConfiguration.xproperties(function(){}, ErrorContainer.handleRestError);

        $scope.createChart = function($formValid){
            $scope.submitAttempted = true;
            if($formValid){
                ChartConfiguration.save($scope.model, function(){
                    growl.addSuccessMessage('Configuratie opgeslagen');
                    $scope.$close();
                }, ErrorContainer.handleRestError);
            }
        };
    }]);
