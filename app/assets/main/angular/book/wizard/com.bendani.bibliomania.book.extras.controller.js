'use strict';

angular.module('com.bendani.bibliomania.book.extras.controller', ['com.bendani.bibliomania.error.container'])
    .controller('BookExtrasController', ['$scope', function ($scope) {
        $scope.data = {};

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

        $scope.data.states = [
            {
                name: "Perfect",
                value: "Perfect"
            },
            {
                name: "Bijna Perfect",
                value: "Bijna Perfect"
            },
            {
                name: "Prima",
                value: "Prima"
            },
            {
                name: "Redelijk",
                value: "Redelijk"
            },
            {
                name: "Slecht",
                value: "Slecht"
            }
        ];
    }]);