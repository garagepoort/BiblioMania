'use strict';

angular.module('com.bendani.bibliomania.book.wizard.controller', ['com.bendani.bibliomania.wizard.oeuvre.controller'])
    .controller('BookWizardController', ['$scope', function ($scope) {

        function init() {
            $scope.book = {};
            $scope.$parent.title = 'Boek wijzigen';
            retrieveBookWizard();
        }

        function retrieveBookWizard() {
            $scope.steps = [
                {
                    title: "Basis",
                    number: 1,
                    modelUrl: "bookwizard/basics",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                },
                {
                    title: "Extra",
                    number: 2,
                    modelUrl: "bookwizard/extras",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-extras.html"
                },
                {
                    title: "Auteur",
                    number: 3,
                    modelUrl: "bookwizard/author",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-author.html"
                }, {
                    title: "Oeuvre",
                    number: 4,
                    templateUrl: "../BiblioMania/views/partials/book/wizard/oeuvre.html"
                }, {
                    title: "Eerste druk",
                    number: 5,
                    modelUrl: "createOrEditBook/step/5",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Persoonlijk",
                    number: 6,
                    modelUrl: "createOrEditBook/step/6",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Koop/Gift",
                    number: 7,
                    modelUrl: "createOrEditBook/step/7",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }, {
                    title: "Cover",
                    number: 8,
                    modelUrl: "createOrEditBook/step/8",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                }];
        }

        init();
    }]);
