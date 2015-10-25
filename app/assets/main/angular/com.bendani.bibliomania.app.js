// Declare app level module which depends on filters, and services
var application = angular.module('BiblioMania', ['ngRoute',
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.book.controller',
    'com.bendani.bibliomania.main.controller',
    'com.bendani.bibliomania.book.card.directive',
    'com.bendani.bibliomania.book.detail.directive',
    'smart-table'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/books', {
                templateUrl: '../BiblioMania/views/partials/books.html',
                controller: 'BookController'
            })
            .otherwise({
                redirectTo: '/'
            });
    }]);