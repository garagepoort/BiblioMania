angular.module('com.bendani.bibliomania.genre.model', [ 'ngResource' ])
    .factory('Genre', ['$resource', function ($resource) {
        return $resource('../BiblioMania/genres', {});
    } ]);