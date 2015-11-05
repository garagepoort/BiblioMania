// Declare app level module which depends on filters, and services
var BiblioManiaUtilities = BiblioManiaUtilities || {};

BiblioManiaUtilities.helpers = {
    dateToString: function(date) {
        if (date != null) {
            result = "";
            if (date.day != "0" && date.day != null) {
                result = date.day + "-";
            }
            if (date.month != "0" && date.month != null) {
                result = result + date.month + "-";
            }
            if (date.year != "0" && date.year != null) {
                result = result + date.year;
            }
            return result
        }
        return "";
    }
};

var application = angular.module('BiblioMania', ['ngRoute',
    'frapontillo.bootstrap-switch',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.error.container.directive',
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.book.controller',
    'com.bendani.bibliomania.login.controller',
    'com.bendani.bibliomania.main.controller',
    'com.bendani.bibliomania.book.card.directive',
    'com.bendani.bibliomania.book.detail.directive',
    'com.bendani.php.common.loginservice.login.directive',
    'com.bendani.php.common.loginservice.authentication.model',
    'com.bendani.bibliomania.book.filter.model',
    'com.bendani.bibliomania.book.filter.sliding.panel.directive',
    'com.bendani.bibliomania.book.filter.select.directive',
    'com.bendani.bibliomania.book.filter.parent',
    'com.bendani.bibliomania.book.filter.boolean.directive',
    'com.bendani.bibliomania.book.filter.text.directive',
    'com.bendani.bibliomania.book.filter.multiselect.directive',
    'smart-table'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/books', {
                templateUrl: '../BiblioMania/views/partials/books.html',
                controller: 'BookController'
            })
            .when('/login', {
                templateUrl: '../BiblioMania/views/partials/login.html',
                controller: 'LoginController'
            })
            .otherwise({
                redirectTo: '/'
            });
    }])
    .run(["$rootScope", "$location", function($rootScope, $location) {
        $rootScope.baseUrl = "../BiblioMania/";
        $rootScope.partialsUrl = "../BiblioMania/views/partials/";
    }]);