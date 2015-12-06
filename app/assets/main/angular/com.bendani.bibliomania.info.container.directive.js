angular.module('com.bendani.bibliomania.info.container.directive', ['com.bendani.bibliomania.error.container'])
    .directive('infocontainer', ['InfoContainer',
        function (InfoContainer) {
            return {
                restrict: 'E',
                templateUrl: '../BiblioMania/views/partials/info-container.html',
                replace: true
            };
        }]);