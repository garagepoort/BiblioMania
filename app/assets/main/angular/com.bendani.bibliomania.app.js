// Declare app level module which depends on filters, and services
var BiblioManiaUtilities = BiblioManiaUtilities || {};

BiblioManiaUtilities.helpers = {
    dateToString: function(date) {
        if (date !== null) {
            var result = "";
            if (date.day !== "0" && date.day !== null) {
                result = date.day + "-";
            }
            if (date.month !== "0" && date.month !== null) {
                result = result + date.month + "-";
            }
            if (date.year !== "0" && date.year !== null) {
                result = result + date.year;
            }
            return result;
        }
        return "";
    }
};

angular.module('BiblioMania', ['ngRoute',
    'ui.bootstrap',
    'ui.bootstrap.tpls',
    'ui.validate',
    'angular-growl',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.error.container.directive',
    'com.bendani.bibliomania.book.controller',
    'com.bendani.bibliomania.book.wizard.controller',
    'com.bendani.bibliomania.login.controller',
    'com.bendani.bibliomania.main.controller',
    'com.bendani.bibliomania.book.card.directive',
    'com.bendani.bibliomania.book.detail.directive',
    'com.bendani.php.common.loginservice.login.directive',
    'com.bendani.php.common.loginservice.authentication.model',
    'com.bendani.bibliomania.book.filter.sliding.panel.directive',
    'com.bendani.bibliomania.library.information.sliding.panel.directive',
    'com.bendani.php.common.wizardservice.wizard.directive',
    'com.bendani.bibliomania.book.basics.controller',
    'com.bendani.bibliomania.book.extras.controller',
    'com.bendani.bibliomania.book.author.controller',
    'com.bendani.bibliomania.create.book.controller',
    'com.bendani.bibliomania.edit.author.ui',
    'com.bendani.bibliomania.create.author.ui',
    'com.bendani.bibliomania.edit.oeuvre.ui',
    'com.bendani.bibliomania.author.selection.controller'])
    .config(['$routeProvider', 'growlProvider', function ($routeProvider, growlProvider) {
        $routeProvider
            .when('/books', {
                templateUrl: '../BiblioMania/views/partials/books.html',
                controller: 'BookController'
            })
            .when('/login', {
                templateUrl: '../BiblioMania/views/partials/login.html',
                controller: 'LoginController'
            })
            .when('/editBook/:step/:modelId?', {
                templateUrl: '../BiblioMania/views/partials/book/wizard/book-wizard.html',
                controller: 'BookWizardController'
            })
            .when('/createBook', {
                templateUrl: '../BiblioMania/views/partials/book/create-book.html',
                controller: 'CreateBookController'
            })
            .otherwise({
                redirectTo: '/books'
            });

        growlProvider.globalTimeToLive(5000);
    }])
    .run(["$rootScope", function($rootScope) {
        $rootScope.baseUrl = "../BiblioMania/";
        $rootScope.partialsUrl = "../BiblioMania/views/partials/";
    }]);