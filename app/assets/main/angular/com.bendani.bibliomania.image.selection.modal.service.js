angular.module('com.bendani.bibliomania.image.selection.modal.service', [])
    .provider('ImageSelectionModalService', function ImageSelectionModalServiceProvider(){
        function ImageSelectionModalService($uibModal) {
            var service = {
                show: function(searchQuery, onSuccessFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/select-image-modal.html',
                        windowClass: 'select-image-modal',
                        controller: 'ImageSelectionController',
                        resolve: {
                            searchQuery: function(){
                                return searchQuery;
                            }
                        }
                    });

                    modalInstance.result.then(onSuccessFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new ImageSelectionModalService($uibModal);
        }];
    })
    .controller('ImageSelectionController', ['$scope', 'searchQuery', function($scope, searchQuery){

        function init(){
            $scope.imageSelectModal = {};
            $scope.imageSelectModal.searchQuery = searchQuery;
        }

        $scope.selectImage = function(){
            $scope.$close($scope.imageSelectModal.imageUrl);
        };

        init();
    }]);