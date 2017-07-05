angular.module('com.bendani.bibliomania.random.facts.model', [ 'ngResource' ])
    .factory('RandomFacts', ['$resource', function ($resource) {
        return $resource('../BiblioMania/randomfacts', {}, {});
    } ]);