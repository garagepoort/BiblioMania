'use strict';

angular.module('com.bendani.bibliomania.create.book.controller', ['ngTagsInput',
    'angularBootstrapNavTree',
    'php.common.uiframework.date',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.genre.model',
    'com.bendani.bibliomania.tag.model',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.language.model'])
    .controller('CreateBookController', ['$scope', 'Genre', 'Tag', 'Country', 'Publisher', 'Language', 'Book',
                'ErrorContainer', '$uibModal',
        function ($scope, Genre, Tag, Country, Publisher, Language, Book, ErrorContainer, $uibModal) {
            $scope.model = {};
            $scope.$parent.title = 'Boek aanmaken';
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

            $scope.showSelectAuthorDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/book/select-author-modal.html',
                    scope: $scope
                });

                modalInstance.result.then(function (author) {
                    $scope.data.selectedAuthor = author;
                    $scope.model.preferredAuthorId = author.id;
                });
            };

            $scope.getAuthorImage = function () {
                if ($scope.data.selectedAuthor === undefined) {
                    return 'images/questionCover.png';
                }
                return $scope.data.selectedAuthor.image;
            };

            $scope.submitForm = function(){
                Book.save($scope.model, function(){

                }, ErrorContainer.handleRestError);
            };
    }]);