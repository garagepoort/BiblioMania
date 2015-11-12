'use strict';

angular.module('com.bendani.bibliomania.book.basics.controller', ['ngTagsInput', 'angularBootstrapNavTree', 'com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.genre.model'])
    .controller('BookBasicsController', ['$scope', 'Genre','ErrorContainer',function ($scope, Genre, ErrorContainer) {
        $scope.data = {};
        $scope.genreTree = {};
        $scope.data.genres = Genre.query(function(genres){}, ErrorContainer.handleRestError);

        $scope.selectGenre = function(branch){
            $scope.container.model.genre = branch.label;
        }
    }]);