angular
    .module('com.bendani.bibliomania.name.directive', [])
    .directive('name', function (){
        return {
            scope: {
                nameModel: "=ngModel",
                submitAttempted: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/name-directive.html"
        };
    });
