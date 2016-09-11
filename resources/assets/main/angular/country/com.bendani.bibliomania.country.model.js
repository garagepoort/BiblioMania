angular.module('com.bendani.bibliomania.country.model', [ 'ngResource' ])
    .factory('Country', ['$resource', function ($resource) {
        return $resource('../BiblioMania/countries', {});
    } ]);