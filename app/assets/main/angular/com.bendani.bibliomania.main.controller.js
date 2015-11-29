angular.module('com.bendani.bibliomania.main.controller', ['com.bendani.bibliomania.error.container'])
    .controller('MainController', ['$scope', '$rootScope', 'ErrorContainer', 'TitlePanelService',
        function ($scope, $rootScope, ErrorContainer, TitlePanelService) {
            $rootScope.errorContainer = ErrorContainer;
            $rootScope.titlePanelService = TitlePanelService;
        }]);