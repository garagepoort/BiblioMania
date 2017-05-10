(function () {
    'use strict';

    angular.module('com.bendani.bibliomania.edit.author.ui',
        ['com.bendani.bibliomania.author.model', 'com.bendani.bibliomania.oeuvre.model',
            'com.bendani.bibliomania.name.directive',
            'com.bendani.bibliomania.add.oeuvre.items.modal.service',
            'com.bendani.bibliomania.confirmation.modal.service',
            'com.bendani.bibliomania.book.list.directive',
            'com.bendani.bibliomania.permission'
        ])
        .config(['$routeProvider', editAuthorConfig])
        .controller('EditAuthorController', ['$scope', '$location', 'Author', 'Oeuvre', 'ErrorContainer', 'growl', '$routeParams', 'AddOeuvreItemsModalService', 'ConfirmationModalService', 'PermissionService', EditAuthorController]);

    function editAuthorConfig($routeProvider) {
        $routeProvider.when('/edit-author/:id', {
            templateUrl: '../BiblioMania/views/partials/author/edit-author.html',
            controller: 'EditAuthorController',
            controllerAs: 'vm'
        });
    }

    function EditAuthorController($scope, $location, Author, Oeuvre, ErrorContainer, growl, $routeParams, AddOeuvreItemsModalService, ConfirmationModalService, PermissionService) {
        var vm = this;

        vm.searchAuthorImage = searchAuthorImage;
        vm.userCanEditAuthor = userCanEditAuthor;
        vm.linkLabel = linkLabel;
        vm.goToOeuvreItem = goToOeuvreItem;
        vm.goToBook = goToBook;
        vm.deleteOeuvreItem = deleteOeuvreItem;
        vm.showAddOeuvreItemsDialog = showAddOeuvreItemsDialog;

        function init() {
            $scope.$parent.title = "Auteur";

            Author.get({id: $routeParams.id}).$promise.then(function (author) { vm.model = author; }).catch(ErrorContainer.handleRestError);
            Author.books({id: $routeParams.id}).$promise.then(function(books){ vm.books = books; }).catch(ErrorContainer.handleRestError);
            Author.oeuvre({id: $routeParams.id}).$promise.then(function(oeuvre){ vm.oeuvre = oeuvre; }).catch(ErrorContainer.handleRestError);

            vm.oeuvreConfig = {
                orderValues: [
                    {key: 'Titel', predicate: 'title', width: '70'},
                    {key: 'Jaar', predicate: 'publicationYear', width: '10'},
                    {key: 'Status', predicate: 'state', width: '10'}
                ],
                predicate: 'publicationYear',
                reverseOrder: false
            };
        }

        function searchAuthorImage() {
            if (vm.model !== undefined && vm.model.name !== undefined) {
                vm.authorImageQuery = vm.model.name.firstname + " " + vm.model.name.lastname;
            }
        }

        function userCanEditAuthor() {
            return PermissionService.hasAllowedPermissions(['UPDATE_AUTHOR']);
        }

        function linkLabel(oeuvreItem) {
            if (oeuvreItem.linkedBooks.length > 0) {
                return 'label-success';
            }
            return 'label-danger';
        }

        function goToOeuvreItem(item) {
            $location.path('/edit-oeuvre-item/' + item.id);
        }

        function goToBook(book) {
            $location.path('/book-details/' + book.id);
        }

        function deleteOeuvreItem(oeuvreItem) {
            ConfirmationModalService.show('Bent u zeker dat u dit item wilt verwijderen: ' + oeuvreItem.title, function () {
                Oeuvre.delete({id: oeuvreItem.id}, function () {
                    vm.oeuvre = Author.oeuvre({id: $routeParams.id});
                    growl.addSuccessMessage("Verwijderen van oeuvre item voltooid");
                }, ErrorContainer.handleRestError);
            });
        }

        function showAddOeuvreItemsDialog() {
            AddOeuvreItemsModalService.show(vm.model.id, function () {
                vm.oeuvre = Author.oeuvre({id: $routeParams.id});
            });
        }

        init();
    }
})();