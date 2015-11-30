'use strict';

angular.module('com.bendani.bibliomania.edit.personal.book.info.ui', [
    'com.bendani.bibliomania.error.container',
    'angular-growl',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.title.panel'
    ])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/edit-personal-book-info/:id', {
            templateUrl: '../BiblioMania/views/partials/personalbookinfo/edit-personal-book-info.html',
            controller: 'PersonalBookInfoController',
            resolve: {
                personalBookInfoModel: ['PersonalBookInfo', '$route', 'ErrorContainer', function(PersonalBookInfo, $route, ErrorContainer){
                    return PersonalBookInfo.get({id: $route.current.params.id }, function(){
                    }, ErrorContainer.handleRestError);
                }],
                onSave:  ['PersonalBookInfo', '$route', 'ErrorContainer', 'growl', function(PersonalBookInfo, $route, ErrorContainer, growl){
                    return function(model){
                        PersonalBookInfo.update(model, function(){
                            growl.addSuccessMessage('Eerste druk opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
        $routeProvider.when('/create-personal-book-info/:bookId?', {
            templateUrl: '../BiblioMania/views/partials/personalbookinfo/edit-personal-book-info.html',
            controller: 'PersonalBookInfoController',
            resolve: {
                personalBookInfoModel: function(){
                    return {};
                },
                onSave:  ['PersonalBookInfo', '$route', 'ErrorContainer', 'growl', '$location',function(PersonalBookInfo, $route, ErrorContainer, growl, $location){
                    return function(model){
                        PersonalBookInfo.save(model, function(response){
                            if($route.current.params.bookId){
                                $location.path('/edit-personal-book-info/' + response.id);
                            }else{
                                $location.path('/edit-personal-book-info' + response.id);
                            }
                            growl.addSuccessMessage('Eerste druk opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
    }])
    .controller('PersonalBookInfoController', ['$scope', 'ErrorContainer', 'TitlePanelService', 'personalBookInfoModel', 'onSave', function ($scope, ErrorContainer, TitlePanelService, personalBookInfoModel, onSave) {
        TitlePanelService.setTitle('Persoonlijke informatie');

        $scope.model = personalBookInfoModel;

        $scope.data = {};

        $scope.submitForm = onSave;

    }]);