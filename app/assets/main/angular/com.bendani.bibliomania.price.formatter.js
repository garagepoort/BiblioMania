angular.module('com.bendani.bibliomania.price.formatter', []).
    directive('priceFormatter', [function() {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function(scope, element, attrs, ngModel) {
                if (!ngModel) return;

                ngModel.$formatters.push(function(value){
                    if(value){
                        return value.toString().replace('.', ',');
                    }
                });

                ngModel.$parsers.push(function(value){
                    if(value){
                        return value.toString().replace(',', '.');
                    }
                });
            }
        };
    }]);