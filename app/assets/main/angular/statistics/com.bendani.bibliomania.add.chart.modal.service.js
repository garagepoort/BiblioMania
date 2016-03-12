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
    .controller('AddChartModalController', ['$scope', function($scope){
    }]);
