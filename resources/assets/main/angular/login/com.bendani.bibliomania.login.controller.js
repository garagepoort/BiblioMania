(function(){
    'use strict';

    angular.module('com.bendani.bibliomania.login.controller', [
        'com.bendani.bibliomania.title.panel'])
        .controller('LoginController', ['$location', 'TitlePanelService', LoginController]);

    function LoginController($location, TitlePanelService) {
        var vm = this;

        vm.goToCreateUser = goToCreateUser;

        function init(){
            TitlePanelService.setShowPreviousButton(false);
        }

        function goToCreateUser(){
            $location.path('/create-user');
        }

        init();
    }
})();
