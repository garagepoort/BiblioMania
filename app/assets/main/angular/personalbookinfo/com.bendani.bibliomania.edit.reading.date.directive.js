'use strict';

angular.module('com.bendani.bibliomania.edit.reading.date.directive',['com.bendani.bibliomania.reading.date.model'])
    .directive('editReadingDate', function (){
        return {
            scope: {
                onSave: "&",
                model: '=readingDateModel',
                personalBookInfoId: '@'
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/personalbookinfo/edit-reading-date-directive.html",
            controller: ['$scope', 'ReadingDate', 'ErrorContainer', function ($scope, ReadingDate, ErrorContainer) {

                $scope.datepicker = {
                    opened: false
                };

                if(!$scope.model){
                    $scope.model = {};
                }

                $scope.submitForm = function(){
                    $scope.model.personalBookInfoId = $scope.personalBookInfoId;
                    if($scope.model.id){
                        ReadingDate.update($scope.model, function(){
                            $scope.onSave($scope.model);
                        }, ErrorContainer.handleRestError);
                    }else{
                        ReadingDate.save($scope.model, function(response){
                            $scope.model.id = response.id;
                            $scope.onSave($scope.model);
                        }, ErrorContainer.handleRestError);
                    }
                };

                $scope.openDatePicker = function () {
                    $scope.datepicker.opened = true;
                };

            }]
        };
    });