angular
    .module('com.bendani.bibliomania.name.directive', [])
    .directive('name', function (){
        return {
            scope: {
                nameModel: "=ngModel"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/name-directive.html",
            controller: ['$scope', function($scope) {
            }]
        };
    });