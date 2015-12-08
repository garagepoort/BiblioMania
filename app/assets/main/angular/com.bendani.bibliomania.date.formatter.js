angular.module('com.bendani.bibliomania.date.formatter', ['com.bendani.bibliomania.date.service']).
    directive('dateFormatter', ['DateService', function(DateService) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, element, attrs, ngModel) {
                if (!ngModel) return;

                ngModel.$formatters.push(function(value){
                    if(value){
                        return DateService.jsonDateToDate(value);
                    }
                });

                ngModel.$parsers.push(function(value){
                    if(value){
                        return DateService.dateToJsonDate(value);
                    }
                });
            }
        };
    }]);