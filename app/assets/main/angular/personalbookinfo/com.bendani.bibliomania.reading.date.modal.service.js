(function () {

    angular.module('com.bendani.bibliomania.reading.date.modal.service', ['com.bendani.bibliomania.reading.date.model', 'com.bendani.bibliomania.personal.book.info.model'])
        .provider('ReadingDateModalService', function ReadingDateModalServiceProvider() {
            function ReadingDateModalService($uibModal) {
                var service = {
                    show: function (personalBookInfoId, onResultFunction, model) {

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
        .controller('ReadingDateModalController', ['$scope', 'ReadingDate', 'ErrorContainer', 'personalBookInfo', 'readingDateModel', ReadingDateModalController]);

    function ReadingDateModalController($scope, ReadingDate, ErrorContainer, personalBookInfo, readingDateModel) {

        function init() {
            $scope.datepicker = {
                opened: false
            };
            $scope.ratingInvalid = false;
            $scope.model = readingDateModel;
            if(!$scope.model){
                $scope.model = {};
            }
        }

        $scope.submitForm = function(){
            $scope.model.personalBookInfoId = personalBookInfo.personalBookInfoId;
            if($scope.model.rating === undefined){
                $scope.ratingInvalid = true;
            }else{
                $scope.ratingInvalid = false;
                if($scope.model.id){
                    ReadingDate.update($scope.model, function(){
                        $scope.$close($scope.model);
                    }, ErrorContainer.handleRestError);
                }else{
                    ReadingDate.save($scope.model, function(response){
                        $scope.model.id = response.id;
                        $scope.$close($scope.model);
                    }, ErrorContainer.handleRestError);
                }
            }
        };

        $scope.openDatePicker = function () {
            $scope.datepicker.opened = true;
        };

        init();
    }
})();