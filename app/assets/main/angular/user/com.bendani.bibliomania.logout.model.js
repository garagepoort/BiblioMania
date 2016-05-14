angular.module('com.bendani.bibliomania.log.out.model', [ 'ngResource' ])
    .factory('LogOut', ['$resource', function ($resource) {
        return $resource('../BiblioMania/logOut', {}, {
            logOut: { method : 'GET', url : '../BiblioMania/logOut'}
        });
    } ]);