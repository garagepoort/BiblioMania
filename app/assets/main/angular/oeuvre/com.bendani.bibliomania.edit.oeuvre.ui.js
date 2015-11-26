'use strict';

angular.module('com.bendani.bibliomania.edit.oeuvre.ui',
    ['com.bendani.bibliomania.oeuvre.model', 'com.bendani.bibliomania.author.model', 'com.bendani.bibliomania.error.container',
        'com.bendani.bibliomania.book.selection.controller', 'angular-growl', 'com.bendani.bibliomania.image.fallback'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/edit-oeuvre-item/:id', {
            templateUrl: '../BiblioMania/views/partials/oeuvre/edit-oeuvre-item.html',
            controller: 'EditOeuvreItemController'
        });
    }])
    .controller('EditOeuvreItemController', ['$scope', 'Oeuvre', 'Author', 'ErrorContainer', 'growl', '$routeParams', '$uibModal', function ($scope, Oeuvre, Author, ErrorContainer, growl, $routeParams, $uibModal) {

        $scope.$parent.title = "Oeuvre";

        $scope.books = Oeuvre.books({id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);
        $scope.model = Oeuvre.get({ id: $routeParams.id }, function(response){
            $scope.$parent.title = response.title;
            $scope.author = Author.get({id: response.authorId}, function(){}, ErrorContainer.handleRestError);
        }, ErrorContainer.handleRestError);

        $scope.submitForm = function(){
            Oeuvre.update($scope.model, function(){
                growl.addSuccessMessage("Oeuvre aangepast");
            }, ErrorContainer.handleRestError);
        };

        $scope.showSelectBookDialog = function () {
            var modalInstance = $uibModal.open({
                templateUrl: '../BiblioMania/views/partials/book/select-book-modal.html',
                scope: $scope
            });

            modalInstance.result.then(function (book) {
                Oeuvre.linkBook({id: $routeParams.id}, {bookId: book.id}, function () {
                    $scope.books = Oeuvre.books({id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);
                    growl.addSuccessMessage("Boek gelinked");
                }, ErrorContainer.handleRestError);
            });
        };

        $scope.deleteBookFromOeuvreItem = function(book){
            Oeuvre.unlinkBook({id: $routeParams.id}, {bookId: book.id}, function () {
                $scope.books = Oeuvre.books({id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);
                growl.addSuccessMessage("Boek link verwijderd");
            }, ErrorContainer.handleRestError);
        };
    }]);