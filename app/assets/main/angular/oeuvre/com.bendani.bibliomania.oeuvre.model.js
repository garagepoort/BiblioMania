angular.module('com.bendani.bibliomania.oeuvre.model', [ 'ngResource' ])
    .factory('Oeuvre', ['$resource', function ($resource) {
        return $resource('../BiblioMania/oeuvre/:id', {}, {
            update: { method: 'PUT' },
            getByBook: { method : 'GET', url : '../BiblioMania/oeuvre/by-book/:id', isArray: true},
            createItems: { method : 'POST', url : '../BiblioMania/oeuvre/create-items'}
        });
    } ]);