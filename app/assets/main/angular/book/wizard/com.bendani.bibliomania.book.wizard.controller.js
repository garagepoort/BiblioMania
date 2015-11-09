'use strict';

angular.module('com.bendani.bibliomania.book.wizard.controller', ['com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.wizard.model'])
    .controller('BookWizardController', ['$scope', 'BookWizard','ErrorContainer',function ($scope, BookWizard, ErrorContainer) {

        function init(){
            $scope.$parent.title = 'Boek wijzigen';
            retrieveBookWizard();
        }

        function retrieveBookWizard(){
            BookWizard.query(function (steps) {
                $scope.steps = steps;
            }, ErrorContainer.handleRestError);
        }
        init();
    }]);