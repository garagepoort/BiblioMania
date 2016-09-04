angular.module('com.bendani.bibliomania.publisher.serie.model', [ 'ngResource' ])
    .factory('PublisherSerie', ['$resource', function ($resource) {
        return $resource('../BiblioMania/publisher-series/:id', {}, {
            update: { method : 'PUT' },
            delete: { method : 'DELETE' },
            addBook: { method : 'POST', url : '../BiblioMania/publisher-series/:id/books'},
            removeBook: { method : 'PUT', url : '../BiblioMania/publisher-series/:id/remove-book'}
        });
    } ]);