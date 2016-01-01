angular.module('com.bendani.php.common.loginservice.authentication.model', [ 'ngResource' ])
    .factory('Authentication', ['$rootScope', '$resource', function ($rootScope, $resource) {
        var url = $rootScope.baseUrl + "login";
        return $resource(url, {});
    } ]);
