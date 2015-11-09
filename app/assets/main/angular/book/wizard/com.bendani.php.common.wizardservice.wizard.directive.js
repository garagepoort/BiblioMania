angular
    .module('com.bendani.php.common.wizardservice.wizard.directive', ['ngRoute'])
    .directive('wizard', function (){
        return {
            scope: {
                steps: "=",
                model: "=",
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/wizard/wizard-directive.html",
            controller: ['$scope', '$routeParams', function($scope, $routeParams) {

            }]
        };
    });