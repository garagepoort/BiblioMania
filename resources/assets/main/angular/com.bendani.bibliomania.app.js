$(function () {
    $('.navbar-toggle').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        $('#search').removeClass('in').addClass('collapse').slideUp(200);

        /// uncomment code for absolute positioning tweek see top comment in css
        //$('.absolute-wrapper').toggleClass('slide-in');

    });

    // Remove menu for searching
    $('#search-trigger').click(function () {
        $('.navbar-nav').removeClass('slide-in');
        $('.side-body').removeClass('body-slide-in');

        /// uncomment code for absolute positioning tweek see top comment in css
        //$('.absolute-wrapper').removeClass('slide-in');

    });
});

angular.module('BiblioMania', ['ngRoute',
    'ui.bootstrap',
    'ui.bootstrap.tpls',
    'ui.validate',
    'pascalprecht.translate',
    'ngSanitize',
    'chart.js',
    'matchMedia',
    'angular-growl',
    'com.bendani.bibliomania.permission',
    'com.bendani.bibliomania.book.controller',
    'com.bendani.bibliomania.login.controller',
    'com.bendani.bibliomania.main.controller',
    'com.bendani.bibliomania.book.detail.directive',
    'com.bendani.php.common.loginservice.login.directive',
    'com.bendani.php.common.loginservice.authentication.model',
    'com.bendani.php.common.uiframework',
    'com.bendani.bibliomania.edit.book.ui',
    'com.bendani.bibliomania.edit.author.ui',
    'com.bendani.bibliomania.edit.oeuvre.ui',
    'com.bendani.bibliomania.book.details.ui',
    'com.bendani.bibliomania.edit.first.print.ui',
    'com.bendani.bibliomania.edit.personal.book.info.ui',
    'com.bendani.bibliomania.author.overview.ui',
    'com.bendani.bibliomania.publisher.overview.ui',
    'com.bendani.bibliomania.series.overview.ui',
    'com.bendani.bibliomania.header.controller',
    'com.bendani.bibliomania.statistics.ui',
    'com.bendani.bibliomania.create.chart.ui',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.random.fact.directive',
    'com.bendani.bibliomania.random.facts.model',
    'com.bendani.bibliomania.create.user.ui'])
    .config(['$routeProvider', 'growlProvider', function ($routeProvider, growlProvider) {
        $routeProvider
            .when('/login', {
                templateUrl: '../BiblioMania/views/partials/login.html',
                controller: 'LoginController',
                controllerAs: 'vm'
            })
            .otherwise({
                redirectTo: '/books'
            });

        growlProvider.globalTimeToLive(5000);
    }])
    .run(['$rootScope', '$location', 'ScrollingService', 'User', 'ErrorContainer', 'RandomFacts', 'screenSize', function($rootScope, $location, ScrollingService, User, ErrorContainer, RandomFacts, screenSize) {
        var history = [];
        $rootScope.baseUrl = "../BiblioMania/";
        $rootScope.mobile = screenSize.is('xs, sm');

        $rootScope.$on('$routeChangeSuccess', function() {
            history.push($location.$$path);
        });

        $rootScope.back = function () {
            var prevUrl = history.length > 1 ? history.splice(-2)[0] : "/";
            $location.path(prevUrl);
        };

        $rootScope.$watch('loggedInUser', function(newValue){
            if(newValue != undefined){
                RandomFacts.query().$promise.then(function(facts){
                    $rootScope.randomFacts = facts;
                }).catch(ErrorContainer.handleRestError);
                $location.path("/books");
            }
        });

        User.loggedInUser(function(user){
            $rootScope.loggedInUser = user;
        }, ErrorContainer.handleRestError);

        ScrollingService.registerPathForScrollPosition('/books');
    }]);