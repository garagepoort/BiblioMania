'use strict';

angular.module('com.bendani.bibliomania.create.book.controller', ['ngTagsInput',
    'angularBootstrapNavTree',
    'php.common.uiframework.date',
    'com.bendani.bibliomania.image.fallback',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.genre.model',
    'com.bendani.bibliomania.tag.model',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.image.selection.controller',
    'com.bendani.bibliomania.language.model'])
    .controller('CreateBookController', ['$scope', 'Genre', 'Tag', 'Country', 'Publisher', 'Language', 'Book',
                'ErrorContainer', '$uibModal', '$location', 'TitlePanelService',
        function ($scope, Genre, Tag, Country, Publisher, Language, Book, ErrorContainer, $uibModal, $location, TitlePanelService) {
            $scope.model = {};
            TitlePanelService.setTitle('Boek aanmaken');

            $scope.data = {};
            $scope.genreTree = {};

            $scope.data.genres = Genre.query(function(){}, ErrorContainer.handleRestError);
            $scope.data.tags = Tag.query(function(){}, ErrorContainer.handleRestError);
            $scope.data.countries = Country.query(function(){}, ErrorContainer.handleRestError);
            $scope.data.publishers = Publisher.query(function(){}, ErrorContainer.handleRestError);
            $scope.data.languages = Language.query(function(){}, ErrorContainer.handleRestError);

            $scope.selectGenre = function(branch){
                $scope.model.genre = branch.label;
            };

            $scope.searchTags = function($query){
                return $scope.data.tags.filter(function (item) {
                    return item.text.toLowerCase().indexOf($query) !== -1;
                });
            };

            $scope.searchBookImage = function () {
                if ($scope.model !== undefined) {
                    $scope.bookImageQuery = $scope.model.title + " " + $scope.model.isbn;
                }
            };

            $scope.openSelectImageDialog = function(){
                if ($scope.model !== undefined) {
                    $scope.imageSelectModal = {};
                    var searchQuery = '';

                    if($scope.model.title){ searchQuery = searchQuery + ' ' + $scope.model.title; }
                    if($scope.model.isbn){ searchQuery = searchQuery + ' ' + $scope.model.isbn; }
                    if($scope.data.selectedAuthor){ searchQuery = searchQuery + ' ' + $scope.data.selectedAuthor.name.lastname; }

                    $scope.imageSelectModal.searchQuery = searchQuery;
                }

                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/select-image-modal.html',
                    scope: $scope,
                    windowClass: 'select-image-modal'
                });

                modalInstance.result.then(function (image) {
                    $scope.model.imageUrl = image;
                });
            };

            $scope.showSelectAuthorDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/author/select-author-modal.html',
                    scope: $scope
                });

                modalInstance.result.then(function (author) {
                    $scope.data.selectedAuthor = author;
                    $scope.data.selectedAuthorImage = author.image;
                    $scope.model.preferredAuthorId = author.id;
                });
            };


            $scope.showCreateAuthorDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/author/create-author-modal.html',
                    scope: $scope,
                    windowClass: 'create-author-dialog'
                });

                modalInstance.result.then(function (author) {
                    $scope.data.selectedAuthor = author;
                    $scope.data.selectedAuthorImage = author.image;
                    $scope.model.preferredAuthorId = author.id;
                });
            };

            $scope.submitForm = function(formValid){
                if(isFormValid(formValid)){
                    Book.save($scope.model, function(){
                        $location.path('books');
                    }, ErrorContainer.handleRestError);
                }
            };

            function isFormValid(formValid){
                var valid = true;
                if(!formValid){
                    ErrorContainer.setErrorCode('Niet alle velden zijn correct ingevuld.');
                    valid = false;
                }
                if($scope.bookImageQuery === undefined){
                    ErrorContainer.setErrorCode('Geen cover geselecteerd');
                    valid = false;
                }
                if($scope.model.preferredAuthorId === undefined){
                    ErrorContainer.setErrorCode('Geen auteur geselecteerd');
                    valid = false;
                }
                return valid;
            }
    }]);