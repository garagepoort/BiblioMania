'use strict';

angular.module('com.bendani.bibliomania.book.basics.controller', ['ngTagsInput',
    'angularBootstrapNavTree',
    'com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.genre.model', 'com.bendani.bibliomania.tag.model',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.language.model'])
    .controller('BookBasicsController', ['$scope', 'Genre', 'Tag', 'Country', 'Publisher', 'Language', 'ErrorContainer',function ($scope, Genre, Tag, Country, Publisher, Language, ErrorContainer) {
        $scope.data = {};
        $scope.genreTree = {};

        $scope.data.genres = Genre.query(function(genres){}, ErrorContainer.handleRestError);
        $scope.data.tags = Tag.query(function(tags){}, ErrorContainer.handleRestError);
        $scope.data.countries = Country.query(function(countries){}, ErrorContainer.handleRestError);
        $scope.data.publishers = Publisher.query(function(publishers){}, ErrorContainer.handleRestError);
        $scope.data.languages = Language.query(function(languages){}, ErrorContainer.handleRestError);

        $scope.selectGenre = function(branch){
            $scope.container.model.genre = branch.label;
        };

        $scope.searchTags = function($query){
            return $scope.data.tags.filter(function (item) {
                return item.text.toLowerCase().indexOf($query) != -1;
            });
        }
    }]);