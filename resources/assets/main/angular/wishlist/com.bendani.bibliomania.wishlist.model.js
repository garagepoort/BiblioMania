angular.module('com.bendani.bibliomania.wishlist.model', [ 'ngResource' ])
    .factory('Wishlist', ['$resource', function ($resource) {
        return $resource('../BiblioMania/wishlist', {}, {
            addBook: { method : 'POST' },
            removeBook: { method : 'PUT', url : '../BiblioMania/wishlist/remove-book'}
        });
    } ]);