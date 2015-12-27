angular.module('com.bendani.bibliomania.book.filter.model', [ 'ngResource' ])
    .factory('BookFilter', ['$resource', function ($resource) {
        return $resource('../BiblioMania/bookFilters', {}, {
            mostUsed: { method : 'GET', url : '../BiblioMania/mostUsedBookFilters', isArray: true},
        });
    } ]);