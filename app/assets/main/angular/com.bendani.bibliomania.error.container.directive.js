angular.module('com.bendani.bibliomania.error.container.directive', ['com.bendani.bibliomania.error.container'])
    .directive('errorcontainer', ['ErrorContainer',
        function (ErrorContainer) {
            return {
                restrict: 'E',
                templateUrl: '../BiblioMania/views/partials/error-container.html',
                replace: true
                //link: function (scope) {
                //    scope.$watch(
                //        function () {
                //            return scope.errorContainer.errorCode;
                //        },
                //        function (newValue, oldValue) {
                //            if (newValue != "") {
                //                ErrorContainer.updateStyling();
                //            }
                //        });
                //}
            }
        }]);