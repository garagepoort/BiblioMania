'use strict';

angular.module('com.bendani.bibliomania.edit.oeuvre.ui',
    ['com.bendani.bibliomania.oeuvre.model',
        'com.bendani.bibliomania.author.model',
        'com.bendani.bibliomania.book.selection.modal.service',
        'com.bendani.bibliomania.confirmation.modal.service',
        'com.bendani.bibliomania.title.panel',
        'angular-growl',
        'com.bendani.bibliomania.image.fallback'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/edit-oeuvre-item/:id', {
            templateUrl: '../BiblioMania/views/partials/oeuvre/edit-oeuvre-item.html',
            controller: 'EditOeuvreItemController'
        });
    }])
    .controller('EditOeuvreItemController', ['$scope', 'Oeuvre', 'Author', 'ErrorContainer', 'growl', '$routeParams', 'BookSelectionModalService', 'ConfirmationModalService', 'TitlePanelService', '$location',
        function ($scope, Oeuvre, Author, ErrorContainer, growl, $routeParams, BookSelectionModalService, ConfirmationModalService, TitlePanelService, $location) {

            TitlePanelService.setTitle("Oeuvre");

            $scope.books = Oeuvre.books({id: $routeParams.id}, function () {}, ErrorContainer.handleRestError);

            $scope.model = Oeuvre.get({id: $routeParams.id}, function (response) {
                $scope.$parent.title = response.title;
                $scope.author = Author.get({id: response.authorId}, function () {
                }, ErrorContainer.handleRestError);
            }, ErrorContainer.handleRestError);

            $scope.submitForm = function () {
                Oeuvre.update($scope.model, function () {
                    growl.addSuccessMessage("Oeuvre aangepast");
                    TitlePanelService.goToPreviousUrl();
                }, ErrorContainer.handleRestError);
            };

            $scope.showSelectBookDialog = function () {
                BookSelectionModalService.show([
                    {id: "book-author", value: [{value: $scope.model.authorId}]}
                ], function (book) {
                    Oeuvre.linkBook({id: $routeParams.id}, {bookId: book.id}, function () {
                        $scope.books = Oeuvre.books({id: $routeParams.id}, function () {
                        }, ErrorContainer.handleRestError);
                        growl.addSuccessMessage("Boek gelinked");
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.deleteBookFromOeuvreItem = function (book) {
                ConfirmationModalService.show('Wilt u de link met het boek "' + book.title + '" verwijderen?', function () {
                    Oeuvre.unlinkBook({id: $routeParams.id}, {bookId: book.id}, function () {
                        $scope.books = Oeuvre.books({id: $routeParams.id}, function () {
                        }, ErrorContainer.handleRestError);
                        growl.addSuccessMessage("Boek link verwijderd");
                    }, ErrorContainer.handleRestError);
                });
            };

            $scope.goToBookDetails = function(book){
                $location.path('/book-details/' + book.id);
            };

        }]);