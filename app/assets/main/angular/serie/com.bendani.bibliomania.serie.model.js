angular.module('com.bendani.bibliomania.serie.model', [ 'ngResource' ])
    .factory('Serie', ['$resource', function ($resource) {
        return $resource('../BiblioMania/series/:id', {}, {
            update: { method : 'PUT' },
            delete: { method : 'DELETE' },
            addBook: { method : 'POST', url : '../BiblioMania/series/:id/books'},
            removeBook: { method : 'PUT', url : '../BiblioMania/series/:id/remove-book'}
        });
    } ]);