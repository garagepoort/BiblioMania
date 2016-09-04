(function () {
    'use strict';

    angular.module('com.bendani.bibliomania.author.overview.ui', [
            'com.bendani.bibliomania.author.model',
            'com.bendani.bibliomania.author.creation.modal.service',
            'com.bendani.bibliomania.image.card.directive',
            'com.bendani.bibliomania.title.panel'])
        .config(['$routeProvider', function ($routeProvider) {
            $routeProvider.when('/authors', {
                templateUrl: '../BiblioMania/views/partials/author/authors-overview.html',
                controller: 'AuthorsOverviewController',
                controllerAs: 'vm'
            });
        }])
        .controller('AuthorsOverviewController', ['$scope', 'Author', 'ErrorContainer', 'TitlePanelService', '$location', '$compile', 'AuthorCreationModalService', AuthorsOverviewController]);

    function AuthorsOverviewController($scope, Author, ErrorContainer, TitlePanelService, $location, $compile, AuthorCreationModalService) {
        var vm = this;
        vm.search = search;
        vm.goToAuthorDetails = goToAuthorDetails;
        vm.showCreateAuthorDialog = showCreateAuthorDialog;
        vm.setListView = setListView;

        function init() {
            TitlePanelService.setTitle('translation.authors');
            TitlePanelService.setShowPreviousButton(false);
            setRightTitlePanel();

            vm.searchAuthorsQuery = "";
            vm.predicate = "name.lastname";
            vm.reverseOrder = false;

            vm.orderValues = [
                {key: 'Voornaam', predicate: 'name.firstname', width: '50'},
                {key: 'Naam', predicate: 'name.lastname', width: '50'}
            ];

            loadAuthors();

        }

        function search(item) {
            if ((item.name.firstname.toLowerCase().indexOf(vm.searchAuthorsQuery) !== -1)
                || (item.name.lastname.toLowerCase().indexOf(vm.searchAuthorsQuery) !== -1)) {
                return true;
            }
            return false;
        }

        function goToAuthorDetails(author) {
            $location.path('/edit-author/' + author.id);
        }

        function showCreateAuthorDialog() {

            AuthorCreationModalService.show(function () {
                loadAuthors();
            });
        }

        function setListView(value) {
            vm.listView = value;
        }

        function loadAuthors() {
            vm.loading = true;
            vm.authors = Author.query(function () {
                vm.loading = false;
            }, ErrorContainer.handleRestError);
        }

        function setRightTitlePanel() {
            var titlePanelRight = angular.element('<button class="btn btn-success no-round-corners" ng-click="vm.showCreateAuthorDialog()">Nieuwe auteur</button>');
            $compile(titlePanelRight)($scope);
            TitlePanelService.setRightPanel(titlePanelRight);
        }

        init();
    }
}());