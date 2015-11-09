'use strict';

angular.module('com.bendani.bibliomania.book.wizard.controller', ['com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.wizard.model', 'com.bendani.bibliomania.book.model'])
    .controller('BookWizardController', ['$scope', 'Book', 'BookWizard','ErrorContainer', '$routeParams',function ($scope, Book, BookWizard, ErrorContainer, $routeParams) {

        function init(){
            $scope.book = {};
            $scope.$parent.title = 'Boek wijzigen';
            retrieveBookWizard();

            var bookId = $routeParams.bookId;

            if(bookId !== undefined){
                retrieveFullBook(bookId);
            }
        }

        function retrieveBookWizard(){
            BookWizard.query(function (steps) {
                $scope.steps = steps;
            }, ErrorContainer.handleRestError);
        }

        function retrieveFullBook(newValue) {
            $scope.book = Book.get({id: newValue}, function (data) {}, ErrorContainer.handleRestError);
        }

        init();
    }]);