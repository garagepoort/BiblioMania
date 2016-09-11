angular.module('com.bendani.bibliomania.author.model', [ 'ngResource' ])
    .factory('Author', ['$resource', function ($resource) {
        return $resource('../BiblioMania/authors/:id', {}, {
            getByBook: { method : 'GET', url : '../BiblioMania/authors/by-book/:id'},
            books: { method : 'GET', url : '../BiblioMania/authors/:id/books', isArray: true},
            oeuvre: { method : 'GET', url : '../BiblioMania/authors/:id/oeuvre', isArray: true},
            update: { method : 'PUT' }
        });
    } ]);