'use strict';

angular.module('com.bendani.bibliomania.book.author.controller', ['com.bendani.bibliomania.name.directive', 'php.common.uiframework.date', 'php.common.uiframework.google.image.search'])
    .controller('BookAuthorController', ['$scope', function ($scope) {

        $scope.addSecondaryAuthor = function () {
            if ($scope.container.model.secondaryAuthors === undefined) {
                $scope.container.model.secondaryAuthors = [];
            }

            $scope.container.model.secondaryAuthors.push({
                firstname: '',
                lastname: '',
                infix: ''
            });
        };

        $scope.searchAuthorImage = function () {
            if ($scope.container.model.preferredAuthor !== undefined) {
                $scope.authorImageQuery = $scope.container.model.preferredAuthor.name.firstname + " " + $scope.container.model.preferredAuthor.name.lastname;
            }
        };

        $scope.getAuthorImage = function () {
            if ($scope.container.model.preferredAuthor === undefined) {
                return 'images/questionCover.png';
            }
            return $scope.container.model.preferredAuthor.image;
        };

        $scope.removeSecondaryAuthor = function (author) {
            var index = $scope.container.model.secondaryAuthors.indexOf(author);
            if (index > -1) {
                $scope.container.model.secondaryAuthors.splice(index, 1);
            }
        };
    }]);