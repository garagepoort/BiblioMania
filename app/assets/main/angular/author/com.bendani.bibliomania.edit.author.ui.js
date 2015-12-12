'use strict';

angular.module('com.bendani.bibliomania.edit.author.ui',
    ['com.bendani.bibliomania.author.model', 'com.bendani.bibliomania.oeuvre.model', 'com.bendani.bibliomania.name.directive', 'php.common.uiframework.date', 'php.common.uiframework.google.image.search', 'com.bendani.bibliomania.error.container', 'angular-growl', 'com.bendani.bibliomania.add.oeuvre.items.modal'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/edit-author/:id', {
            templateUrl: '../BiblioMania/views/partials/author/edit-author.html',
            controller: 'EditAuthorController'
        });
    }])
    .controller('EditAuthorController', ['$scope', 'Author', 'Oeuvre', 'ErrorContainer', 'growl', '$routeParams', '$uibModal', function ($scope, Author, Oeuvre, ErrorContainer, growl, $routeParams, $uibModal) {

        $scope.$parent.title = "Auteur";
        $scope.model = Author.get({ id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);
        $scope.books = Author.books({ id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);
        $scope.oeuvre = Author.oeuvre({ id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);

        $scope.searchAuthorImage = function () {
            if ($scope.model !== undefined) {
                $scope.authorImageQuery = $scope.model.name.firstname + " " + $scope.model.name.lastname;
            }
        };

        $scope.getAuthorImage = function () {
            if ($scope.model.image === undefined) {
                return 'images/questionCover.png';
            }
            return $scope.model.image;
        };

        $scope.linkLabel = function(oeuvreItem){
            if(oeuvreItem.linkedBooks.length > 0){
                return 'label-success';
            }
            return 'label-danger';
        };

        $scope.linkText = function(oeuvreItem){
            if(oeuvreItem.linkedBooks.length > 0){
                return 'LINKED';
            }
            return 'UNLINKED';
        };

        $scope.deleteOeuvreItem = function(oeuvreItem){
            growl.addInfoMessage("Oeuvre item wordt verwijderd");
            Oeuvre.delete({ id: oeuvreItem.id}, function(){
                $scope.oeuvre = Author.oeuvre({ id: $routeParams.id });
                growl.addSuccessMessage("Verwijderen van oeuvre item voltooid");
            }, ErrorContainer.handleRestError);
        };

        $scope.showAddOeuvreItemsDialog = function () {
            var modalInstance = $uibModal.open({
                templateUrl: '../BiblioMania/views/partials/oeuvre/add-oeuvre-items-modal.html',
                scope: $scope
            });

            modalInstance.result.then(function () {
                $scope.oeuvre = Author.oeuvre({ id: $routeParams.id });
            });
        };
    }]);