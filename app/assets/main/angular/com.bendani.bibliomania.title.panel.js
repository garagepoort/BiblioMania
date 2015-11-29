angular.module("com.bendani.bibliomania.title.panel", [])
    .provider('TitlePanelService', function TitlePanelServiceProvider() {

        function TitlePanelService($rootScope) {
            var _title;
            var _rightPanel;

            var _getTitle = function(){
                return _title;
            };

            var _setTitle = function(title){
                _title = title;
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
                setRightPanel: _setRightPanel
            };

            return service;

        }

        this.$get = ['$rootScope', function ($rootScope) {
            return new TitlePanelService($rootScope);
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
