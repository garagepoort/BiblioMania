(function () {
    'use strict';

    angular.module('com.bendani.bibliomania.permission', ['com.bendani.bibliomania.user.model'])
        .factory('PermissionService', ['$rootScope', permissionService])
        .directive('permission', ['ngIfDirective', 'PermissionService', permission]);

    function permissionService($rootScope) {

        function trim(toBeTrimmed) {
            return toBeTrimmed.replace(/^\s+|\s+$/g, "");
        }

        function getUserPermissions() {
            if(!$rootScope.loggedInUser){
                return [];
            }
            return $rootScope.loggedInUser.permissions;
        }

        function hasAllowedPermissions(permissionsAllowed) {
            if (permissionsAllowed === undefined) {
                return false;
            }
            if (permissionsAllowed.length === 1 && permissionsAllowed[0] === 'ANY') {
                return true;
            }

            return _.any(permissionsAllowed, function (permission) {
                return getUserPermissions().indexOf(permission) > -1;
            });
        }

        function hasPermission(allowedPermission) {
            var permissions = getUserPermissions();
            if (allowedPermission === undefined || permissions === undefined) {
                return false;
            }
            for (var i = 0; i < permissions.length; i++) {
                if (permissions[i] === allowedPermission.trim()) {
                    return true;
                }
            }
            return false;
        }

        return {
            getUserPermissions: getUserPermissions,
            hasAllowedPermissions: hasAllowedPermissions,
            hasPermission: hasPermission
        };
    }

    function permission(ngIfDirective, PermissionService) {

        var ngIf = ngIfDirective[0];

        return {
            transclude: ngIf.transclude,
            priority: ngIf.priority - 1,
            terminal: ngIf.terminal,
            restrict: ngIf.restrict,
            link: directiveLinkFn
        };

        function directiveLinkFn(scope, element, attributes) {
            var initialNgIfAttribute = attributes.ngIf;

            attributes.ngIf = hasNgIfOnElement() ? evaluateNgIfAttributesAndPermissions : evaluatePermissions;
            ngIf.link.apply(ngIf, arguments);

            function evaluateNgIfAttributesAndPermissions() {
                return scope.$eval(initialNgIfAttribute) && evaluatePermissions();
            }

            function evaluatePermissions() {
                var requiredPermissions = convertPermissionsLiteralOrExpressionToArray(scope, attributes.permission);
                return PermissionService.hasAllowedPermissions(requiredPermissions);
            }

            function hasNgIfOnElement() {
                return !!initialNgIfAttribute;
            }
        }

        function isPermissionExpression(value) {
            return value !== undefined && !isCommaSeparatedListOfPermissions(value);
        }

        function isCommaSeparatedListOfPermissions(value) {
            return value.match(/^[A-Z0-9_]+([ ]*,[ ]*[A-Z0-9_]+)*$/);
        }

        function convertPermissionsLiteralOrExpressionToArray(scope, permission) {
            var permissions = isPermissionExpression(permission) ? scope.$eval(permission) : permission;
            if (permissions === undefined) {
                return [];
            }
            return splitByCommaIfNotAnArray(permissions);
        }

        function splitByCommaIfNotAnArray(value) {
            return Array.isArray(value) ? value : value.split(',');
        }
    }
})();