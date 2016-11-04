(function () {
    'use strict';

    angular.module('com.bendani.bibliomania.permission.directive', ['com.bendani.bibliomania.user.model'])
        .directive('permission', ['User', permission]);

    function permission(User) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.hide();

                User.loggedInUser().$promise.then(function(user){
                    var userPermissions = user.permissions;
                    if (userPermissions) {
                        var permissionsToCheck = attrs.permission.split(',');
                        var hasPermission = _.any(permissionsToCheck, function (permission) {
                            return userPermissions.indexOf(permission) > -1;
                        });

                        if (hasPermission) {
                            element.show();
                        }
                    }
                });
            }
        };
    }
})();