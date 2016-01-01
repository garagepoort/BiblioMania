angular.module('com.bendani.bibliomania.publisher.serie.model', [ 'ngResource' ])
    .factory('PublisherSerie', ['$resource', function ($resource) {
        return $resource('../BiblioMania/publisher-series', {});
    } ]);