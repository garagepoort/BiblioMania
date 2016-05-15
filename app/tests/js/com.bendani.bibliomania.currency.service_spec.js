describe('com.bendani.bibliomania.currency.service', function () {

    var EURO = {name: "€", value: "EUR"};
    var DOLLAR = {name: "$", value: "USD"};
    var POUND = {name: "£", value: "PND"};

    describe('CurrencyService', function () {
        var currencyService;

        beforeEach(function () {
            module('com.bendani.bibliomania.currency.service');

            inject(function (_CurrencyService_) {
                currencyService = _CurrencyService_;
            });
        });

        describe('getCurrencies', function () {
            it('should return correct currencies', function () {
                expect(currencyService.getCurrencies()[0]).toEqual(EURO);
                expect(currencyService.getCurrencies()[1]).toEqual(DOLLAR);
                expect(currencyService.getCurrencies()[2]).toEqual(POUND);
            });
        });

        describe('getCurrencyModelValue', function () {
            it('should return PND for pound sign', function () {
                expect(currencyService.getCurrencyModelValue('£')).toEqual('PND');
            });

            it('should return USD for dollar sign', function () {
                expect(currencyService.getCurrencyModelValue('$')).toEqual('USD');
            });

            it('should return EUR for euro sign', function () {
                expect(currencyService.getCurrencyModelValue('€')).toEqual('EUR');
            });
        });

        describe('getCurrencyViewValue', function () {
            it('should return pound sign for PND', function () {
                expect(currencyService.getCurrencyViewValue('PND')).toEqual('£');
            });

            it('should return dollar sign for USD', function () {
                expect(currencyService.getCurrencyViewValue('USD')).toEqual('$');
            });

            it('should return euro sign for EUR', function () {
                expect(currencyService.getCurrencyViewValue('EUR')).toEqual('€');
            });
        });
    });

});
