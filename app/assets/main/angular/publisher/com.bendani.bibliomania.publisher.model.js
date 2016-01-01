angular.module('com.bendani.bibliomania.publisher.model', [ 'ngResource' ])
    .factory('Publisher', ['$resource', function ($resource) {
        return $resource('../BiblioMania/publishers', {});
    } ]);