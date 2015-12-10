angular.module('BiblioMania', ['ngRoute',
    'ui.bootstrap',
    'ui.bootstrap.tpls',
    'ui.validate',
    'angular-growl',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.error.container.directive',
    'com.bendani.bibliomania.info.container',
    'com.bendani.bibliomania.info.container.directive',
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
    'com.bendani.bibliomania.edit.oeuvre.ui',
    'com.bendani.bibliomania.book.details.ui',
    'com.bendani.bibliomania.edit.first.print.ui',
    'com.bendani.bibliomania.edit.personal.book.info.ui',
    'com.bendani.bibliomania.title.panel'])
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
            .when('/create-book', {
                templateUrl: '../BiblioMania/views/partials/book/create-book.html',
                controller: 'CreateBookController'
            })
            .otherwise({
                redirectTo: '/books'
            });

        growlProvider.globalTimeToLive(5000);
    }])
    .run(['$rootScope', '$location', function($rootScope, $location) {
        var history = [];
        $rootScope.baseUrl = "../BiblioMania/";

        $rootScope.$on('$routeChangeSuccess', function() {
            history.push($location.$$path);
        });

        $rootScope.back = function () {
            var prevUrl = history.length > 1 ? history.splice(-2)[0] : "/";
            $location.path(prevUrl);
        };

        $rootScope.partialsUrl = "../BiblioMania/views/partials/";
    }]);