'use strict';

angular.module('com.bendani.bibliomania.confirmation.modal.service', [])
    .provider('ConfirmationModalService', function ConfirmationModalServiceProvider() {

        function ConfirmationModalService($uibModal) {
            var service = {
                show: function(message, onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/confirmation-modal.html',
                        controller: 'ConfirmationModalController',
                        resolve: {
                            message: function(){
                                return message;
                            }
                        }
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new ConfirmationModalService($uibModal);
        }];
    })
    .controller('ConfirmationModalController', ['$scope', 'message', function($scope, message){
        $scope.message = message;
    }]);
