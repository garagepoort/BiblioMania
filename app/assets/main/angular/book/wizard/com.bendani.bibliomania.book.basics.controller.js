'use strict';

angular.module('com.bendani.bibliomania.book.basics.controller', ['ngTagsInput',
    'angularBootstrapNavTree', 'angucomplete',
    'com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.genre.model', 'com.bendani.bibliomania.tag.model',
    'com.bendani.bibliomania.country.model'])
    .controller('BookBasicsController', ['$scope', 'Genre', 'Tag', 'Country', 'ErrorContainer',function ($scope, Genre, Tag, Country, ErrorContainer) {
        $scope.data = {};
        $scope.genreTree = {};
        $scope.data.genres = Genre.query(function(genres){}, ErrorContainer.handleRestError);
        $scope.data.tags = Tag.query(function(tags){}, ErrorContainer.handleRestError);
        $scope.data.countries = Country.query(function(countries){}, ErrorContainer.handleRestError);

        $scope.selectGenre = function(branch){
            $scope.container.model.genre = branch.label;
        }

        $scope.searchTags = function($query){
            return $scope.data.tags.filter(function (item) {
                return item.text.toLowerCase().indexOf($query) != -1;
            });
        }
    }]);