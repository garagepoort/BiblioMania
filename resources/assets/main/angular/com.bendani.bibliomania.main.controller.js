angular.module('com.bendani.bibliomania.main.controller', [
    'com.bendani.bibliomania.user.model',
    'com.bendani.bibliomania.log.out.model'
])
    .controller('MainController', ['$scope', '$rootScope', 'ErrorContainer', 'InfoContainer', 'TitlePanelService', 'LogOut', '$location',
        function ($scope, $rootScope, ErrorContainer, InfoContainer, TitlePanelService, LogOut, $location) {
            $rootScope.errorContainer = ErrorContainer;
            $rootScope.infoContainer = InfoContainer;
            $rootScope.titlePanelService = TitlePanelService;


            $scope.logOut = function(){
                LogOut.logOut(function(){
                    $location.path('#/login');
                }, ErrorContainer.handleRestError);
            };
        }]);