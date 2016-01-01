angular.module('com.bendani.bibliomania.image.selection.controller', [])
    .controller('ImageSelectionController', ['$scope', function($scope){

        function init(){
            if($scope.imageSelectModal === undefined){
                $scope.imageSelectModal = {};
                $scope.imageSelectModal.searchQuery = '';
            }
        }

        $scope.selectImage = function(){
            $scope.$close($scope.imageSelectModal.imageUrl);
        };

        init();
    }]);