angular.module('com.bendani.bibliomania.book.model', [ 'ngResource' ])
    .factory('Book', ['$resource', function ($resource) {
        return $resource('../BiblioMania/books/:id', {});
    } ]);