angular.module('com.bendani.bibliomania.user.model', [ 'ngResource' ])
    .factory('User', ['$resource', function ($resource) {
        return $resource('../BiblioMania/users/:id', {}, {
            loggedInUser: { method : 'GET', url : '../BiblioMania/loggedInUser'}
        });
    } ]);