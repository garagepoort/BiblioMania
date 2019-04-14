angular.module('com.bendani.bibliomania.main.controller', [
    'com.bendani.bibliomania.user.model',
    'com.bendani.bibliomania.log.out.model'
])
    .controller('MainController', ['$scope', '$rootScope', 'ErrorContainer', 'InfoContainer', 'TitlePanelService', 'LogOut', '$location',
        function ($scope, $rootScope, ErrorContainer, InfoContainer, TitlePanelService, LogOut, $location) {
            $rootScope.errorContainer = ErrorContainer;
            $rootScope.infoContainer = InfoContainer;
            $rootScope.titlePanelService = TitlePanelService;

            $scope.slideInOpen = false;

            $scope.toggleSlideIn = function() {
                $scope.slideInOpen = !$scope.slideInOpen;
            };

            $scope.logOut = function(){
                LogOut.logOut(function(){
                    $rootScope.randomFacts = [];
                    $location.path('#/login');
                }, ErrorContainer.handleRestError);
            };
        }]);