angular.module('com.bendani.bibliomania.main.controller', ['com.bendani.bibliomania.error.container'])
    .controller('MainController', ['$scope', '$rootScope', 'ErrorContainer',
        function ($scope, $rootScope, ErrorContainer) {
            $scope.helpers = BiblioManiaUtilities.helpers;
            $scope.title = '    ';
            $rootScope.errorContainer = ErrorContainer;
        }]);