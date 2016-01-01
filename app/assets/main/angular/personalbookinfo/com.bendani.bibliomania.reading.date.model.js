angular.module('com.bendani.bibliomania.reading.date.model', [ 'ngResource' ])
    .factory('ReadingDate', ['$resource', function ($resource) {
        return $resource('../BiblioMania/reading-dates/:id', {}, {
            update: { method : 'PUT', url : '../BiblioMania/reading-dates'}
        });
    } ]);