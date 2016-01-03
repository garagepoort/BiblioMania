angular.module('com.bendani.bibliomania.main.controller', ['com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.info.container',
    'com.bendani.bibliomania.user.model'
])
    .controller('MainController', ['$scope', '$rootScope', 'ErrorContainer', 'InfoContainer', 'TitlePanelService', 'User',
        function ($scope, $rootScope, ErrorContainer, InfoContainer, TitlePanelService, User) {
            $rootScope.errorContainer = ErrorContainer;
            $rootScope.infoContainer = InfoContainer;
            $rootScope.titlePanelService = TitlePanelService;
        }]);