(function(){
    'use strict';

    angular.module('com.bendani.bibliomania.login.controller', ['com.bendani.bibliomania.title.panel'])
        .controller('LoginController', ['$rootScope','$location', 'TitlePanelService', LoginController]);

    function LoginController($rootScope, $location, TitlePanelService) {
        var vm = this;

        vm.goToCreateUser = goToCreateUser;

        function init(){
            $rootScope.$watch('loggedInUser', function(newValue){
                if(newValue != undefined){
                    $location.path("/books");
                }
            });

            TitlePanelService.setShowPreviousButton(false);
        }

        function goToCreateUser(){
            $location.path('/create-user');
        }

        init();
    }
})();
