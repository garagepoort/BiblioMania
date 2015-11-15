'use strict';

angular.module('com.bendani.bibliomania.book.wizard.controller', ['com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.model'])
    .controller('BookWizardController', ['$scope', 'Book', 'ErrorContainer', '$routeParams', function ($scope, Book, ErrorContainer, $routeParams) {

        function init() {
            $scope.book = {};
            $scope.$parent.title = 'Boek wijzigen';
            retrieveBookWizard();
        }

        function retrieveBookWizard() {
            $scope.steps = [
                {
                    title: "Basis",
                    number: 0,
                    modelUrl: "bookBasics",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                },
                {
                    title: "Extra",
                    number: 1,
                    modelUrl: "createOrEditBook/step/2",
                },
                {
                    title: "Auteur",
                    number: 2,
                    modelUrl: "createOrEditBook/step/3",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Oeuvre",
                    number: 3,
                    modelUrl: "createOrEditBook/step/4",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Eerste druk",
                    number: 4,
                    modelUrl: "createOrEditBook/step/5",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Persoonlijk",
                    number: 5,
                    modelUrl: "createOrEditBook/step/6",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Koop/Gift",
                    number: 6,
                    modelUrl: "createOrEditBook/step/7",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Cover",
                    number: 7,
                    modelUrl: "createOrEditBook/step/8",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }];
        }

        init();
    }]);