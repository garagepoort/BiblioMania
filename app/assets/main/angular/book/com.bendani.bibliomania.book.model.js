angular.module('com.bendani.bibliomania.book.model', [ 'ngResource' ])
    .factory('Book', ['$resource', function ($resource) {
        return $resource('../BiblioMania/books/:id', {}, {
            linkAuthor: { method : 'PUT', url : '../BiblioMania/books/:id/authors'},
            unlinkAuthor: { method : 'PUT', url : '../BiblioMania/books/:id/unlink-author'}
        });
    } ]);