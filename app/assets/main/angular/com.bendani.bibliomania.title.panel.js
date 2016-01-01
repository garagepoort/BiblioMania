angular.module("com.bendani.bibliomania.title.panel", [])
    .provider('TitlePanelService', function TitlePanelServiceProvider() {

        function TitlePanelService($rootScope, $location) {
            var _title;
            var _rightPanel;
            var _previousUrl;
            var _showPreviousButton = true;

            var _resetPanel = function(){
                _title = undefined;
                angular.element('#titlePanelRightPanel').empty();
                _previousUrl = undefined;
                _showPreviousButton = true;
            };

            var _getTitle = function(){
                return _title;
            };

            var _setTitle = function(title){
                _title = title;
            };

            var _getPreviousUrl = function(){
                return _previousUrl;
            };

            var _goToPreviousUrl = function(){
                if(_previousUrl !== undefined){
                    $location.path(_previousUrl);
                }else{
                    $rootScope.back();
                }
            };

            var _setPreviousUrl = function(url){
                _previousUrl = url;
            };

            var _shouldShowPreviousButton = function(){
                return _showPreviousButton;
            };

            var _setShowPreviousButton = function(show){
              _showPreviousButton = show;
            };

            var _setRightPanel = function(rightPanel){
                angular.element('#titlePanelRightPanel').empty();
                angular.element('#titlePanelRightPanel').append(rightPanel);
                _rightPanel = rightPanel;
            };

            var _getRightPanel = function(){
                return _rightPanel;
            };

            var service = {
                getTitle: _getTitle,
                setTitle: _setTitle,
                getRightPanel: _getRightPanel,
                setRightPanel: _setRightPanel,
                resetPanel: _resetPanel,
                getPreviousUrl: _getPreviousUrl,
                setPreviousUrl: _setPreviousUrl,
                goToPreviousUrl: _goToPreviousUrl,
                shouldShowPreviousButton: _shouldShowPreviousButton,
                setShowPreviousButton: _setShowPreviousButton
            };

            $rootScope.$on('$routeChangeSuccess', service.resetPanel);

            return service;

        }

        this.$get = ['$rootScope', '$location', function ($rootScope, $location) {
            return new TitlePanelService($rootScope, $location);
        }];
    })
    .directive('titlePanel', ['TitlePanelService',
        function (TitlePanelService) {
            return {
                restrict: 'E',
                templateUrl: '../BiblioMania/views/partials/title-panel.html',
                replace: true
            };
    }]);
