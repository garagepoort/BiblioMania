angular.module('com.bendani.bibliomania.author.model', [ 'ngResource' ])
    .factory('Author', ['$resource', function ($resource) {
        return $resource('../BiblioMania/authors/:id', {}, {
            getByBook: { method : 'GET', url : '../BiblioMania/authors/by-book/:id'}
        });
    } ]);