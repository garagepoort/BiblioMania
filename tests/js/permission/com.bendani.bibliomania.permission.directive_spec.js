describe('com.bendani.bibliomania.permission.directive', function () {

    describe('PermissionService', function () {

        var permissionService;
        var $httpBackend, $rootScope;


        beforeEach(function () {

            module('com.bendani.bibliomania.permission');

            inject(['PermissionService', '$httpBackend', '$rootScope', function (PermissionService, _$httpBackend_, _$rootScope_) {
                permissionService = PermissionService;
                $httpBackend = _$httpBackend_;
                $rootScope = _$rootScope_;
            }]);

        });

        describe('getUserPermissions', function () {
            it('returns empty array when no loggedInUser', function () {
                var userPermissions = permissionService.getUserPermissions();

                expect(userPermissions.length).toEqual(0);
            });

            it('returns loggedInUser permissions', function () {
                $rootScope.loggedInUser = {permissions: ['permission1', 'permission2']};

                var userPermissions = permissionService.getUserPermissions();

                expect(userPermissions).toEqual(['permission1', 'permission2']);
            });
        });

        describe('hasAllowedPermissions', function () {
            it('returns false when allowed permissions is undefined', function () {
                var hasAllowedPermissions = permissionService.hasAllowedPermissions();

                expect(hasAllowedPermissions).toBe(false);
            });

            it('returns true when allowed permissions is ANY', function () {
                var hasAllowedPermissions = permissionService.hasAllowedPermissions(['ANY']);

                expect(hasAllowedPermissions).toBe(true);
            });
            
            it('returns false when user has any none the allowed permissions', function () {
                $rootScope.loggedInUser = {permissions: ['permission1', 'permission2']};

                var hasAllowedPermissions = permissionService.hasAllowedPermissions(['permission3']);

                expect(hasAllowedPermissions).toBe(false);
            });

            it('returns true when user has any of the allowed permissions', function () {
                $rootScope.loggedInUser = {permissions: ['permission1', 'permission2']};

                var hasAllowedPermissions = permissionService.hasAllowedPermissions(['permission2']);

                expect(hasAllowedPermissions).toBe(true);
            });
        });

    });
});
