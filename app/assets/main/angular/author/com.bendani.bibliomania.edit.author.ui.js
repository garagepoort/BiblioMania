'use strict';

angular.module('com.bendani.bibliomania.edit.author.ui',
    ['com.bendani.bibliomania.author.model', 'com.bendani.bibliomania.oeuvre.model',
        'com.bendani.bibliomania.name.directive', 'php.common.uiframework.date',
        'php.common.uiframework.google.image.search',
        'com.bendani.bibliomania.error.container', 'angular-growl',
        'com.bendani.bibliomania.add.oeuvre.items.modal',
        'com.bendani.bibliomania.confirmation.modal.service',
        'com.bendani.bibliomania.book.list.directive'
    ])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/edit-author/:id', {
            templateUrl: '../BiblioMania/views/partials/author/edit-author.html',
            controller: 'EditAuthorController'
        });
    }])
    .controller('EditAuthorController', ['$scope', '$location', 'Author', 'Oeuvre', 'ErrorContainer', 'growl', '$routeParams', '$uibModal', 'ConfirmationModalService', function ($scope, $location, Author, Oeuvre, ErrorContainer, growl, $routeParams, $uibModal, ConfirmationModalService) {

        $scope.$parent.title = "Auteur";
        $scope.model = Author.get({ id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);
        $scope.books = Author.books({ id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);
        $scope.oeuvre = Author.oeuvre({ id: $routeParams.id }, function(){}, ErrorContainer.handleRestError);

        $scope.searchAuthorImage = function () {
            if ($scope.model !== undefined) {
                $scope.authorImageQuery = $scope.model.name.firstname + " " + $scope.model.name.lastname;
            }
        };

        $scope.linkLabel = function(oeuvreItem){
            if(oeuvreItem.linkedBooks.length > 0){
                return 'label-success';
            }
            return 'label-danger';
        };

        $scope.goToOeuvreItem = function(item){
            $location.path('/edit-oeuvre-item/'+item.id);
        };
        $scope.goToBook = function(book){
            $location.path('/book-details/'+book.id);
        };

        $scope.linkText = function(oeuvreItem){
            if(oeuvreItem.linkedBooks.length > 0){
                return 'LINKED';
            }
            return 'UNLINKED';
        };

        $scope.deleteOeuvreItem = function(oeuvreItem){
            ConfirmationModalService.show('Bent u zeker dat u dit item wilt verwijderen: ' + oeuvreItem.title, function(){
                Oeuvre.delete({ id: oeuvreItem.id}, function(){
                    $scope.oeuvre = Author.oeuvre({ id: $routeParams.id });
                    growl.addSuccessMessage("Verwijderen van oeuvre item voltooid");
                }, ErrorContainer.handleRestError);
            });
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