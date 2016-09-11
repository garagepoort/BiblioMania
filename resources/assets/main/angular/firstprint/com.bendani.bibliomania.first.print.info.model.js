angular.module('com.bendani.bibliomania.first.print.info.model', [ 'ngResource' ])
    .factory('FirstPrintInfo', ['$resource', function ($resource) {
        return $resource('../BiblioMania/firstprints/:id', {}, {
            update: { method: 'PUT' },
            linkBook: { method : 'POST', url : '../BiblioMania/firstprints/:id/books'}
        });
    } ]);