'use strict';

angular.module('com.bendani.bibliomania.book.author.controller', ['com.bendani.bibliomania.name.directive', 'com.bendani.bibliomania.date.directive', 'com.bendani.bibliomania.google.image.search.directive'])
    .controller('BookAuthorController', ['$scope', function ($scope) {
        $scope.data = {};

        $scope.addSecondaryAuthor = function(){
            if($scope.container.model.secondaryAuthors === undefined){
                $scope.container.model.secondaryAuthors = [];
            }

            $scope.container.model.secondaryAuthors.push({
                firstname : '',
                lastname : '',
                infix : ''
            });
        }

        $scope.removeSecondaryAuthor = function(author){
            var index = $scope.container.model.secondaryAuthors.indexOf(author);
            if (index > -1) {
                $scope.container.model.secondaryAuthors.splice(index, 1);
            }
        }
    }]);