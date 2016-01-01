angular.module('com.bendani.bibliomania.date.selection.modal.service', [])
    .provider('DateSelectionModalService', function DateSelectionModalServiceProvider(){
        function DateSelectionModalService($uibModal) {
            var service = {
                show: function(onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/book/select-date-modal.html'
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new DateSelectionModalService($uibModal);
        }];
    })
    .controller('DateSelectionController', ['$scope', function($scope){

        function init(){
            $scope.model = {};
            $scope.model.readingDate = new Date();
        }

        $scope.selectDate = function(){
            $scope.$close($scope.model.readingDate);
        };

        init();
    }]);