'use strict';

angular.module('com.bendani.bibliomania.edit.personal.book.info.ui', [
    'com.bendani.bibliomania.error.container',
    'angular-growl',
    'com.bendani.bibliomania.personal.book.info.model',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.date.service',
    'com.bendani.bibliomania.title.panel'
])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/edit-personal-book-info/:id', {
            templateUrl: '../BiblioMania/views/partials/personalbookinfo/edit-personal-book-info.html',
            controller: 'PersonalBookInfoController',
            resolve: {
                personalBookInfoModel: ['PersonalBookInfo', '$route', 'ErrorContainer', function (PersonalBookInfo, $route, ErrorContainer) {
                    return PersonalBookInfo.get({id: $route.current.params.id}, function () {
                    }, ErrorContainer.handleRestError);
                }],
                onSave: ['PersonalBookInfo', '$route', 'ErrorContainer', 'growl', function (PersonalBookInfo, $route, ErrorContainer, growl) {
                    return function (model) {
                        PersonalBookInfo.update(model, function () {
                            growl.addSuccessMessage('Eerste druk opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }]
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
                        reasonNotInCollection: 'BORROWED'
                    };
                },
                onSave: ['PersonalBookInfo', '$route', 'ErrorContainer', 'growl', '$location', function (PersonalBookInfo, $route, ErrorContainer, growl, $location) {
                    return function (model) {
                        model.bookId=$route.current.params.bookId;
                        PersonalBookInfo.save(model, function () {
                            $location.path('/book-details/' + $route.current.params.bookId);
                            growl.addSuccessMessage('Eerste druk opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }]
            }
        });
    }])
    .controller('PersonalBookInfoController', ['$scope', 'ErrorContainer', 'TitlePanelService', 'personalBookInfoModel', 'onSave', 'Country', 'DateService', function ($scope, ErrorContainer, TitlePanelService, personalBookInfoModel, onSave, Country, DateService) {
        function init() {
            $('#star').raty(
                {
                    score: function () {
                        return $('#star-rating-input').val();
                    },
                    number: 10,
                    path: '../BiblioMania/assets/lib/raty-2.7.0/lib/images',
                    click: function (score) {
                        $('#star-rating-input').val(score);
                    }
                }
            );

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
                    if(model.buyInfo.buyDate){
                        model.buyInfo.buyDate = DateService.dateToJsonDate(model.buyInfo.buyDate);
                    }
                    model.giftInfo = undefined;
                }else{
                    if(model.giftInfo.giftDate){
                        model.giftInfo.giftDate = DateService.dateToJsonDate(model.giftInfo.giftDate);
                    }
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

        init();
    }]);