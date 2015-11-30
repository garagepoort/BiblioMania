'use strict';

angular.module('com.bendani.bibliomania.edit.first.print.ui', ['com.bendani.bibliomania.error.container',
    'angular-growl',
    'com.bendani.bibliomania.first.print.info.model',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.language.model',
    'com.bendani.bibliomania.title.panel'
    ])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/edit-first-print/:id', {
            templateUrl: '../BiblioMania/views/partials/firstprint/edit-first-print.html',
            controller: 'FirstPrintController',
            resolve: {
                firstPrintInfoModel: ['FirstPrintInfo', '$route', 'ErrorContainer', function(FirstPrintInfo, $route, ErrorContainer){
                    return FirstPrintInfo.get({id: $route.current.params.id }, function(){
                    }, ErrorContainer.handleRestError);
                }],
                onSave:  ['FirstPrintInfo', '$route', 'ErrorContainer', 'growl', function(FirstPrintInfo, $route, ErrorContainer, growl){
                    return function(model){
                        FirstPrintInfo.update(model, function(){
                            growl.addSuccessMessage('Eerste druk opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
        $routeProvider.when('/create-first-print', {
            templateUrl: '../BiblioMania/views/partials/firstprint/edit-first-print.html',
            controller: 'FirstPrintController',
            resolve: {
                firstPrintInfoModel: function(){
                    return {};
                },
                onSave:  ['FirstPrintInfo', '$route', 'ErrorContainer', 'growl', '$location',function(FirstPrintInfo, $route, ErrorContainer, growl, $location){
                    return function(model){
                        FirstPrintInfo.save(model, function(response){
                            $location.path('/edit-first-print/' + response.id);
                            growl.addSuccessMessage('Eerste druk opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
        $routeProvider.when('/create-first-print-and-link-to-book/:bookId', {
            templateUrl: '../BiblioMania/views/partials/firstprint/edit-first-print.html',
            controller: 'FirstPrintController',
            resolve: {
                firstPrintInfoModel: function(){
                    return {};
                },
                onSave:  ['FirstPrintInfo', '$route', 'ErrorContainer', 'growl', '$location',function(FirstPrintInfo, $route, ErrorContainer, growl, $location){
                    return function(model){
                        model.bookIdToLink = $route.current.params.bookId;
                        FirstPrintInfo.save(model, function(){
                            growl.addSuccessMessage('Eerste druk opgeslagen');
                            $location.path('/book-details/' + $route.current.params.bookId);
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
    }])
    .controller('FirstPrintController', ['$scope', 'ErrorContainer', 'Country', 'Language', 'Publisher', 'TitlePanelService', 'firstPrintInfoModel', 'onSave', function ($scope, ErrorContainer, Country, Language, Publisher, TitlePanelService, firstPrintInfoModel, onSave) {
        TitlePanelService.setTitle('Eerste druk');

        $scope.model = firstPrintInfoModel;

        $scope.data = {};

        $scope.data.countries = Country.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.publishers = Publisher.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.languages = Language.query(function(){}, ErrorContainer.handleRestError);

        $scope.submitForm = onSave;

    }]);