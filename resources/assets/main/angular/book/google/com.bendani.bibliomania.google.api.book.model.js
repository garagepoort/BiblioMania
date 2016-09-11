angular.module('com.bendani.bibliomania.google.api.book.model', [ 'ngResource' ])
    .factory('GoogleApiBook', ['$resource', function ($resource) {
        return $resource('https://www.googleapis.com/books/v1/volumes', {
            'key': 'AIzaSyBPkSNgxg9ZjRgYnS0Fj6fZ9xw-Xn5l_pw'
        });
    } ]);