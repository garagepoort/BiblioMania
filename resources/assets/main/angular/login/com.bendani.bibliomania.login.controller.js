'use strict';

angular.module('com.bendani.bibliomania.login.controller', [])
    .controller('LoginController', ['$scope', '$rootScope','$location',function ($scope, $rootScope, $location) {
        function init(){
            $scope.$parent.title = 'Login';
            $rootScope.$watch('loggedInUser', function(newValue){
                if(newValue != undefined){
                    $location.path("/books");
                }
            });
        }
        init();
    }]);