angular.module('com.bendani.bibliomania.personal.book.info.model', [ 'ngResource' ])
    .factory('PersonalBookInfo', ['$resource', function ($resource) {
        return $resource('../BiblioMania/personalbookinfos/:id', {}, {
            addReadingDate: { method : 'POST', url : '../BiblioMania/personalbookinfos/:id/readingdates'},
            deleteReadingDate: { method : 'PUT', url : '../BiblioMania/personalbookinfos/:id/delete-reading-date'},
            readingDates: { method : 'GET', url : '../BiblioMania/personalbookinfos/:id/readingdates', isArray: true}
        });
    } ]);