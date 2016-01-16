angular.module('com.bendani.bibliomania.reading.date.modal.service', ['com.bendani.bibliomania.edit.reading.date.directive'])
    .provider('ReadingDateModalService', function ReadingDateModalServiceProvider(){
        function ReadingDateModalService($uibModal) {
            var service = {
                show: function(personalBookInfoId, onResultFunction, model) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/personalbookinfo/edit-reading-date-modal.html',
                        controller: 'ReadingDateModalController',
                        resolve: {
                            personalBookInfo: {
                                personalBookInfoId: personalBookInfoId
                            },
                            readingDateModel: model
                        }
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new ReadingDateModalService($uibModal);
        }];
    })
    .controller('ReadingDateModalController', ['$scope', 'ErrorContainer', 'personalBookInfo', 'readingDateModel', function($scope, ErrorContainer, personalBookInfo, readingDateModel){

        function init(){
            $scope.data = {};
            $scope.data.readingDateModel = readingDateModel;
            $scope.data.personalBookInfoId = personalBookInfo.personalBookInfoId;
            $scope.data.onSaveReadingDate = function(readingDate){
                $scope.$close(readingDate);
            };
        }
        init();
    }]);