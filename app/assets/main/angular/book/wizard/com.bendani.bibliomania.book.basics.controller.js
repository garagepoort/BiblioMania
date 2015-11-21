'use strict';

angular.module('com.bendani.bibliomania.book.basics.controller', ['ngTagsInput',
    'angularBootstrapNavTree',
    'php.common.uiframework.date',
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.genre.model',
    'com.bendani.bibliomania.tag.model',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.language.model'])
    .controller('BookBasicsController', ['$scope', 'Genre', 'Tag', 'Country', 'Publisher', 'Language', 'ErrorContainer',function ($scope, Genre, Tag, Country, Publisher, Language, ErrorContainer) {
        $scope.data = {};
        $scope.genreTree = {};

        $scope.data.genres = Genre.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.tags = Tag.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.countries = Country.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.publishers = Publisher.query(function(){}, ErrorContainer.handleRestError);
        $scope.data.languages = Language.query(function(){}, ErrorContainer.handleRestError);

        $scope.selectGenre = function(branch){
            $scope.container.model.genre = branch.label;
        };

        $scope.searchTags = function($query){
            return $scope.data.tags.filter(function (item) {
                return item.text.toLowerCase().indexOf($query) !== -1;
            });
        };
    }]);
