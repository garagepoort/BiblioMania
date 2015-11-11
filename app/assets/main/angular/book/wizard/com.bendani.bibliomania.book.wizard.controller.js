'use strict';

angular.module('com.bendani.bibliomania.book.wizard.controller', ['com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.wizard.model', 'com.bendani.bibliomania.book.model'])
    .controller('BookWizardController', ['$scope', 'Book', 'BookWizard','ErrorContainer', '$routeParams',function ($scope, Book, BookWizard, ErrorContainer, $routeParams) {

        function init(){
            $scope.book = {};
            $scope.book.id = $routeParams.bookId;
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