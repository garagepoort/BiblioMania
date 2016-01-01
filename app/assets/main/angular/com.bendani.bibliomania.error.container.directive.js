angular.module('com.bendani.bibliomania.error.container.directive', ['com.bendani.bibliomania.error.container'])
    .directive('errorcontainer',
        function () {
            return {
                restrict: 'E',
                templateUrl: '../BiblioMania/views/partials/error-container.html',
                replace: true
            };
        });