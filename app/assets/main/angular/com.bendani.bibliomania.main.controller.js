angular.module('com.bendani.bibliomania.main.controller', ['com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.info.container'])
    .controller('MainController', ['$scope', '$rootScope', 'ErrorContainer', 'InfoContainer', 'TitlePanelService',
        function ($scope, $rootScope, ErrorContainer, InfoContainer, TitlePanelService) {
            $rootScope.errorContainer = ErrorContainer;
            $rootScope.infoContainer = InfoContainer;
            $rootScope.titlePanelService = TitlePanelService;
        }]);