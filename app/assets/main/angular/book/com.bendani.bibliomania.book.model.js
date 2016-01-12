angular.module('com.bendani.bibliomania.book.model', [ 'ngResource' ])
    .factory('Book', ['$resource', function ($resource) {
        return $resource('../BiblioMania/books/:id', {}, {
            update: { method: 'PUT' },
            searchAllBooks: { method : 'POST', url : '../BiblioMania/books/search-all-books', isArray: true},
            searchOtherBooks: { method : 'POST', url : '../BiblioMania/books/search-other-books', isArray: true},
            searchMyBooks: { method : 'POST', url : '../BiblioMania/books/search-my-books', isArray: true},
            searchWishlist: { method : 'POST', url : '../BiblioMania/books/search-wishlist', isArray: true},
            linkAuthor: { method : 'PUT', url : '../BiblioMania/books/:id/authors'},
            unlinkAuthor: { method : 'PUT', url : '../BiblioMania/books/:id/unlink-author'}
        });
    } ]);