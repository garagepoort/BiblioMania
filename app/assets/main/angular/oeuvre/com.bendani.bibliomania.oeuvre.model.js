angular.module('com.bendani.bibliomania.oeuvre.model', [ 'ngResource' ])
    .factory('Oeuvre', ['$resource', function ($resource) {
        return $resource('../BiblioMania/oeuvre/:id', {}, {
            update: { method: 'PUT' },
            createItems: { method : 'POST', url : '../BiblioMania/oeuvre/create-items'},
            books: { method : 'GET', url : '../BiblioMania/oeuvre/:id/books', isArray: true},
            linkBook: { method : 'POST', url : '../BiblioMania/oeuvre/:id/books'},
            unlinkBook: { method : 'PUT', url : '../BiblioMania/oeuvre/:id/unlink-book'}
        });
    } ]);