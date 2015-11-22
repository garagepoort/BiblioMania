'use strict';

angular.module('com.bendani.bibliomania.wizard.first.print.controller', [
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.language.model'])
    .controller('WizardFirstPrintController', ['$scope', 'Country', 'Publisher', 'Language', 'ErrorContainer', function ($scope, Country, Publisher, Language, ErrorContainer) {
        $scope.data = {};
        $scope.data.countries = Country.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.publishers = Publisher.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.languages = Language.query(function(){}, ErrorContainer.handleRestError);
    }]);