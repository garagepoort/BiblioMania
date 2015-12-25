'use strict';

angular.module('com.bendani.bibliomania.author.overview.ui', [
    'com.bendani.bibliomania.author.model',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.author.creation.modal.service',
    'com.bendani.bibliomania.title.panel'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/authors', {
            templateUrl: '../BiblioMania/views/partials/author/authors-overview.html',
            controller: 'AuthorsOverviewController'
        });
    }])
    .controller('AuthorsOverviewController', ['$scope', 'Author', 'ErrorContainer', 'TitlePanelService', '$location', '$compile', 'AuthorCreationModalService',
        function ($scope, Author, ErrorContainer, TitlePanelService, $location, $compile, AuthorCreationModalService) {

            function init() {
                TitlePanelService.setTitle('Auteurs');
                TitlePanelService.setShowPreviousButton(false);
                setRightTitlePanel();

                $scope.searchAuthorsQuery = "";
                $scope.predicate = "name.lastname";
                $scope.reverseOrder = false;

                $scope.orderValues = [
                    {key: 'Voornaam', predicate: 'name.firstname', width: '50'},
                    {key: 'Naam', predicate: 'name.lastname', width: '50'}
                ];

                loadAuthors();

            }

            $scope.search = function (item) {
                if ((item.name.firstname.toLowerCase().indexOf($scope.searchAuthorsQuery) !== -1)
                    || (item.name.lastname.toLowerCase().indexOf($scope.searchAuthorsQuery) !== -1)) {
                    return true;
                }
                return false;
            };

            $scope.goToAuthorDetails = function (author) {
                $location.path('/edit-author/' + author.id);
            };

            $scope.showCreateAuthorDialog = function(){

                AuthorCreationModalService.show(function(){
                    loadAuthors();
                });
            };

            function loadAuthors() {
                $scope.loading = true;
                $scope.authors = Author.query(function () {
                    $scope.loading = false;
                }, ErrorContainer.handleRestError);
            }

            function setRightTitlePanel() {
                var titlePanelRight = angular.element('<button class="btn btn-success no-round-corners" ng-click="showCreateAuthorDialog()">Nieuwe auteur</button>');
                $compile(titlePanelRight)($scope);
                TitlePanelService.setRightPanel(titlePanelRight);
            }

            init();
        }]);