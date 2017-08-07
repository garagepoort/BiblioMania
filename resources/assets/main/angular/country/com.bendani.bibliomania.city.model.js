angular.module('com.bendani.bibliomania.city.model', [ 'ngResource' ])
    .factory('City', ['$resource', function ($resource) {
        return $resource('../BiblioMania/cities', {});
    } ]);