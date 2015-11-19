angular
    .module('com.bendani.bibliomania.date.directive', [])
    .directive('date', function (){
        return {
            scope: {
                label: '@',
                dateModel: "=ngModel",
                required: '@'
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/date-directive.html",
            controller: ['$scope', function($scope) {

                function init(){
                    if($scope.dateModel === undefined){
                        $scope.dateModel = {};
                    }
                }

                $scope.isYearRequired = function(){
                    if($scope.required == true){
                        return true;
                    }
                    return $scope.dateModel.day != undefined || $scope.dateModel.month != undefined;
                };

                $scope.isMonthRequired = function(){
                    return $scope.dateModel.day != undefined;
                };

                init();
            }]
        };
    });