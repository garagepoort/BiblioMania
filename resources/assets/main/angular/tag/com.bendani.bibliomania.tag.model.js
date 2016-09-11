angular.module('com.bendani.bibliomania.tag.model', [ 'ngResource' ])
    .factory('Tag', ['$resource', function ($resource) {
        return $resource('../BiblioMania/tags', {});
    } ]);