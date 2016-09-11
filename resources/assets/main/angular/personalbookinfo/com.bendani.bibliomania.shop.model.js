angular.module('com.bendani.bibliomania.shop.model', [ 'ngResource' ])
    .factory('Shop', ['$resource', function ($resource) {
        return $resource('../BiblioMania/shops', {});
    } ]);