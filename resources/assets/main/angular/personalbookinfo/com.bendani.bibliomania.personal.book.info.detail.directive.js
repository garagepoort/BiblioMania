angular
    .module('com.bendani.bibliomania.personal.book.info.detail.directive', ['com.bendani.bibliomania.currency.service'])
    .directive('personalBookInfoDetail', function (){
        return {
            scope: {
                personalBookInfo: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/personalbookinfo/personal-book-info-detail-directive.html",
            controller: ['$scope', 'DateService', 'CurrencyService', function($scope, DateService, CurrencyService){
                $scope.dateToString = DateService.dateToString;
                $scope.getCurrencyViewValue = CurrencyService.getCurrencyViewValue;
            }]
        };
    });