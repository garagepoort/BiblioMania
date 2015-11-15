'use strict';

angular.module('com.bendani.bibliomania.book.wizard.controller', ['com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.model'])
    .controller('BookWizardController', ['$scope', 'Book', 'ErrorContainer', '$routeParams', function ($scope, Book, ErrorContainer, $routeParams) {

        function init() {
            $scope.book = {};
            $scope.book.id = $routeParams.bookId;
            $scope.$parent.title = 'Boek wijzigen';
            retrieveBookWizard();
        }

        function retrieveBookWizard() {
            $scope.steps = [
                {
                    title: "Basis",
                    number: 0,
                    modelUrl: "createOrEditBook/step/1",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                },
                {
                    title: "Extra",
                    number: 1,
                    modelUrl: "createOrEditBook/step/2",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                },
                {
                    title: "Auteur",
                    number: 2,
                    modelUrl: "createOrEditBook/step/3",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                }, {
                    title: "Oeuvre",
                    number: 3,
                    modelUrl: "createOrEditBook/step/4",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                }, {
                    title: "Eerste druk",
                    number: 4,
                    modelUrl: "createOrEditBook/step/5",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                }, {
                    title: "Persoonlijk",
                    number: 5,
                    modelUrl: "createOrEditBook/step/6",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                }, {
                    title: "Koop/Gift",
                    number: 6,
                    modelUrl: "createOrEditBook/step/7",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                }, {
                    title: "Cover",
                    number: 7,
                    modelUrl: "createOrEditBook/step/8",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html",
                    controller: "BookBasicsController"
                }];
        }

        init();
    }]);