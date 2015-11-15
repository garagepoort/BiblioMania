angular.module('com.bendani.bibliomania.language.model', [ 'ngResource' ])
    .factory('Language', ['$resource', function ($resource) {
        return $resource('../BiblioMania/languages', {});
    } ]);