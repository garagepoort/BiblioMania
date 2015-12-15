angular.module('com.bendani.bibliomania.personal.book.info.model', [ 'ngResource' ])
    .factory('PersonalBookInfo', ['$resource', function ($resource) {
        return $resource('../BiblioMania/personalbookinfos/:id', {}, {
            update: { method : 'PUT', url : '../BiblioMania/personalbookinfos/:id'},
            readingDates: { method : 'GET', url : '../BiblioMania/personalbookinfos/:id/readingdates', isArray: true}
        });
    } ]);