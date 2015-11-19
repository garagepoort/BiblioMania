'use strict';

angular.module('com.bendani.bibliomania.book.wizard.controller', [])
    .controller('BookWizardController', ['$scope', function ($scope) {

        function init() {
            $scope.book = {};
            $scope.$parent.title = 'Boek wijzigen';
            $scope.successHandler = function(){
                NotificationRepository.showNotification({
                    title: "Boek opgeslagen",
                    message: "",
                    type: "success"
                });
            };
            retrieveBookWizard();
        }

        function retrieveBookWizard() {
            $scope.steps = [
                {
                    title: "Basis",
                    number: 1,
                    modelUrl: "bookBasics",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
                },
                {
                    title: "Extra",
                    number: 2,
                    modelUrl: "bookExtras",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-extras.html"
                },
                {
                    title: "Auteur",
                    number: 3,
                    modelUrl: "bookAuthor",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-author.html"
                }, {
                    title: "Oeuvre",
                    number: 4,
                    modelUrl: "createOrEditBook/step/4",
                    templateUrl: "../BiblioMania/views/partials/book/wizard/book-basics.html"
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