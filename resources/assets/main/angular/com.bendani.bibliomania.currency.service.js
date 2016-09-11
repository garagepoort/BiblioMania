'use strict';

angular.module('com.bendani.bibliomania.currency.service', [])
    .provider('CurrencyService', function CurrencyServiceProvider() {

        function CurrencyService() {
            var currencies = [
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

            var service = {
                getCurrencies: function() {
                    return currencies;
                },
                getCurrencyViewValue: function(value){
                    var currency = _.where(currencies, {value: value});
                    if(currency.length > 0){
                        return currency[0].name;
                    }
                },
                getCurrencyModelValue: function(name){
                    var currency = _.where(currencies, {name: name});
                    if(currency.length > 0){
                        return currency[0].value;
                    }
                }
            };

            return service;
        }

        this.$get = function () {
            return new CurrencyService();
        };
    });
