angular.module('com.bendani.bibliomania.header.controller', [])
    .controller('HeaderController', ['$scope', '$location',
        function ($scope, $location) {
            $scope.isActive = function (viewLocation) {
                return viewLocation === $location.path();
            };
        }]);