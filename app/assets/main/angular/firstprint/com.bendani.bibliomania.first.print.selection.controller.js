angular.module('com.bendani.bibliomania.first.print.selection.controller', ['com.bendani.bibliomania.first.print.info.model'])
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
            if ((item.title.toLowerCase().indexOf($scope.firstPrintSelectionModal.searchFirstPrintQuery) !== -1)){
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