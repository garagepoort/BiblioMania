angular.module('com.bendani.bibliomania.first.print.selection.modal.service', ['com.bendani.bibliomania.first.print.info.model'])
    .provider('FirstPrintSelectionModalService', function FirstPrintSelectionModalServiceProvider(){
        function FirstPrintSelectionModalService($uibModal) {
            var service = {
                show: function(onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/firstprint/select-first-print-modal.html'
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new FirstPrintSelectionModalService($uibModal);
        }];
    })
    .controller('FirstPrintSelectionController', ['$scope', 'FirstPrintInfo', 'ErrorContainer', function($scope, FirstPrintInfo, ErrorContainer){

        function init(){
            $scope.firstPrintSelectionModal = {};
            $scope.firstPrintSelectionModal.data = {};
            $scope.firstPrintSelectionModal.data.firstPrints = FirstPrintInfo.query(function(){}, ErrorContainer.handleRestError);
            $scope.firstPrintSelectionModal.searchFirstPrintQuery = '';
            $scope.firstPrintSelectionModal.predicate = 'title';
            $scope.firstPrintSelectionModal.reverse = false;
        }

        $scope.selectFirstPrint = function(firstPrint){
            $scope.$close(firstPrint);
        };

        $scope.search = function(item){
            if (item.title && (item.title.toLowerCase().indexOf($scope.firstPrintSelectionModal.searchFirstPrintQuery) !== -1)){
                return true;
            }
            return false;
        };

        $scope.order = function(predicate) {
            $scope.firstPrintSelectionModal.reverse = ($scope.firstPrintSelectionModal.predicate === predicate) ? !$scope.firstPrintSelectionModal.reverse : false;
            $scope.firstPrintSelectionModal.predicate = predicate;
        };

        init();
    }]);