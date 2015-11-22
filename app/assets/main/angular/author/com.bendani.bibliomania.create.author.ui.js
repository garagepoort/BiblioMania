'use strict';

angular.module('com.bendani.bibliomania.create.author.ui',
    ['com.bendani.bibliomania.author.model', 'com.bendani.bibliomania.name.directive', 'php.common.uiframework.date', 'php.common.uiframework.google.image.search', 'com.bendani.bibliomania.error.container', 'angular-growl'])
    .config(['$routeProvider',function ($routeProvider) {
        $routeProvider.when('/create-author', {
            templateUrl: '../BiblioMania/views/partials/author/create-author.html',
            controller: 'CreateAuthorController'
        });
    }])
    .controller('CreateAuthorController', ['$scope', 'Author', 'ErrorContainer', '$location', function ($scope, Author, ErrorContainer, growl, $location) {

        $scope.$parent.title = "Auteur";
        $scope.model = {};

        $scope.searchAuthorImage = function () {
            if ($scope.model !== undefined) {
                $scope.authorImageQuery = $scope.model.name.firstname + " " + $scope.model.name.lastname;
            }
        };

        $scope.getAuthorImage = function () {
            if ($scope.model.image === undefined) {
                return 'images/questionCover.png';
            }
            return $scope.model.image;
        };

        $scope.submitForm = function(){
            if($scope.model.dateOfBirth !== undefined){
                if($scope.model.dateOfBirth.year === null || $scope.model.dateOfBirth.year === undefined){
                    $scope.model.dateOfBirth = undefined;
                }
            }
            if($scope.model.dateOfDeath !== undefined){
                if($scope.model.dateOfDeath.year === null || $scope.model.dateOfDeath.year === undefined){
                    $scope.model.dateOfDeath = undefined;
                }
            }
            Author.save($scope.model, function(response){
                $location.path('/edit-author/' + response.id);
                growl.addSuccessMessage("Auteur opgeslagen");
            }, ErrorContainer.handleRestError);
        };

    }]);