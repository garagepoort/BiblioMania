angular.module('com.bendani.bibliomania.wishlist.model', [ 'ngResource' ])
    .factory('Wishlist', ['$resource', function ($resource) {
        return $resource('../BiblioMania/users/:id/wishlist', {}, {
            get: { method : 'GET', url : '../BiblioMania/users/:id/wishlist', isArray: true},
            addBook: { method : 'POST', url : '../BiblioMania/users/:id/wishlist'},
            removeBook: { method : 'PUT', url : '../BiblioMania/users/:id/wishlist/remove-book'}
        });
    } ]);