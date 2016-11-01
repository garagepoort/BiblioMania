(function(){
    'use strict';

    angular.module('com.bendani.bibliomania.login.controller', [])
        .controller('LoginController', ['$rootScope','$location', LoginController]);

    function LoginController($rootScope, $location) {
        var vm = this;

        vm.goToCreateUser = goToCreateUser;

        function init(){
            $rootScope.$watch('loggedInUser', function(newValue){
                if(newValue != undefined){
                    $location.path("/books");
                }
            });
        }

        function goToCreateUser(){
            $location.path('/create-user');
        }

        init();
    }
})();
