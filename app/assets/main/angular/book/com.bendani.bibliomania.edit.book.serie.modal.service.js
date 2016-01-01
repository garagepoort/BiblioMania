angular.module('com.bendani.bibliomania.edit.book.serie.modal.service', [
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.serie.model'
    ])
    .provider('EditBookSerieModalService', function EditBookSerieModalServiceProvider(){
        function EditBookSerieModalService($uibModal) {
            var service = {
                show: function(serie, onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/book/edit-book-serie-modal.html',
                        controller: 'EditBookSerieModalController',
                        resolve: {
                            serieModel: serie
                        }
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new EditBookSerieModalService($uibModal);
        }];
    })
    .controller('EditBookSerieModalController', ['$scope', 'Serie', 'ErrorContainer', 'serieModel', 'growl', function($scope, Serie, ErrorContainer, serieModel, growl){

        function init(){
            $scope.model = serieModel;
            $scope.submitAttempted = false;
        }

        $scope.submit = function(valid){
            $scope.submitAttempted = true;
            if(valid){
                Serie.update($scope.model, function(){
                    growl.addSuccessMessage('Serie opgeslagen');
                }, ErrorContainer.handleRestError);
            }
        };
        init();
    }]);