'use strict';

angular.module('com.bendani.bibliomania.edit.personal.book.info.ui', [
    'angular-growl',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.price.formatter'
])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/edit-personal-book-info/:id', {
            templateUrl: '../BiblioMania/views/partials/personalbookinfo/edit-personal-book-info.html',
            controller: 'PersonalBookInfoController',
            resolve: {
                personalBookInfoModel: ['PersonalBookInfo', '$route', 'ErrorContainer', 'Book', 'InfoContainer', function (PersonalBookInfo, $route, ErrorContainer, Book, InfoContainer) {
                    return PersonalBookInfo.get({id: $route.current.params.id}, function (personalInfo) {
                        Book.get({id: personalInfo.bookId}, function(book){
                            InfoContainer.setInfoCode('Deze persoonlijke informatie is voor het boek: ' + book.title);
                        }, ErrorContainer.handleRestError);
                    }, ErrorContainer.handleRestError);
                }],
                onSave: ['PersonalBookInfo', '$route', 'ErrorContainer', 'growl', '$location', function (PersonalBookInfo, $route, ErrorContainer, growl, $location) {
                    return function (model) {
                        PersonalBookInfo.update(model, function () {
                            $location.path('/book-details/' + model.bookId);
                            growl.addSuccessMessage('Persoonlijke informatie opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }],
                initFunction: function(){ return function(){}; }
            }
        });
        $routeProvider.when('/create-personal-book-info/:bookId', {
            templateUrl: '../BiblioMania/views/partials/personalbookinfo/edit-personal-book-info.html',
            controller: 'PersonalBookInfoController',
            resolve: {
                personalBookInfoModel: function () {
                    return {
                        acquirement: 'BUY',
                        inCollection: true,
                        buyInfo: {},
                        reasonNotInCollection: 'BORROWED'
                    };
                },
                onSave: ['PersonalBookInfo', '$route', 'ErrorContainer', 'growl', '$location', function (PersonalBookInfo, $route, ErrorContainer, growl, $location) {
                    return function (model) {
                        model.bookId=$route.current.params.bookId;
                        PersonalBookInfo.save(model, function () {
                            $location.path('/book-details/' + $route.current.params.bookId);
                            growl.addSuccessMessage('Persoonlijke informatie opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }],
                initFunction: ['Book', 'InfoContainer', '$route', 'ErrorContainer', function(Book, InfoContainer, $route, ErrorContainer){
                    return function(){
                        Book.get({id: $route.current.params.bookId}, function(book){
                            InfoContainer.setInfoCode('Deze persoonlijke informatie is voor het boek: ' + book.title);
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
    }])
    .controller('PersonalBookInfoController', ['$scope', 'ErrorContainer', 'TitlePanelService', 'personalBookInfoModel', 'onSave', 'Country', 'initFunction', function ($scope, ErrorContainer, TitlePanelService, personalBookInfoModel, onSave, Country, initFunction) {
        function init() {
            TitlePanelService.setTitle('Persoonlijke informatie');

            $scope.model = personalBookInfoModel;
            $scope.data = {};

            $scope.data.countries = Country.query(function(){}, ErrorContainer.handleRestError);
            $scope.data.currencies = [
                {
                    name: "€",
                    value: "EUR"
                },
                {
                    name: "$",
                    value: "USD"
                },
                {
                    name: "£",
                    value: "PND"
                }
            ];

            $scope.submitForm = function(model){
                if(model.acquirement === 'BUY'){
                    model.giftInfo = undefined;
                }else{
                    model.buyInfo = undefined;
                }

                onSave(model);
            };

            $scope.datepicker = {
                opened: false
            };
        }

        $scope.openDatePicker = function () {
            $scope.datepicker.opened = true;
        };

        initFunction();
        init();
    }]);