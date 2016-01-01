angular.module('com.bendani.bibliomania.serie.model', [ 'ngResource' ])
    .factory('Serie', ['$resource', function ($resource) {
        return $resource('../BiblioMania/series', {}, {
            update: { method : 'PUT' }
        });
    } ]);