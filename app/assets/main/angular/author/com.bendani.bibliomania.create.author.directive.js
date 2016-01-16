'use strict';

angular.module('com.bendani.bibliomania.create.author.directive',
    [
        'com.bendani.bibliomania.author.model',
        'com.bendani.bibliomania.name.directive',
        'php.common.uiframework.date',
        'php.common.uiframework.google.image.search',
        'angular-growl',
        'com.bendani.bibliomania.title.panel'
    ])
    .directive('createAuthor', function (){
        return {
            scope: {
                onSave: "&",
                model: '=authorModel'
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/author/create-author-directive.html",
            controller: ['$scope', 'Author', 'ErrorContainer', 'growl', '$uibModal', 'TitlePanelService', function ($scope, Author, ErrorContainer, growl, $uibModal, TitlePanelService) {

                TitlePanelService.setTitle('Auteur');
                $scope.submitAttempted = false;

                if(!$scope.model){
                    $scope.model = {};
                }

                $scope.searchAuthorImage = function () {
                    if ($scope.model !== undefined) {
                        $scope.authorImageQuery = $scope.model.name.firstname + " " + $scope.model.name.lastname;
                    }
                };

                $scope.openSelectImageDialog = function(){
                    $scope.imageSelectModal = {};
                    var searchQuery = '';

                    if($scope.model.name){ searchQuery = $scope.model.name.firstname + ' ' + $scope.model.name.lastname; }

                    $scope.imageSelectModal.searchQuery = searchQuery;

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/select-image-modal.html',
                        scope: $scope,
                        windowClass: 'select-image-modal'
                    });

                    modalInstance.result.then(function (image) {
                        $scope.model.imageUrl = image;
                        $scope.model.image = image;
                    });
                };

                $scope.submitForm = function(formValid){
                    $scope.submitAttempted = true;
                    if(formValid){
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
                        if($scope.model.id){
                            Author.update($scope.model, function(response){
                                growl.addSuccessMessage("Auteur opgeslagen");
                                $scope.onSave({authorId: response.id});
                            }, ErrorContainer.handleRestError);
                        }else{
                            Author.save($scope.model, function(response){
                                growl.addSuccessMessage("Auteur opgeslagen");
                                $scope.onSave({authorId: response.id});
                            }, ErrorContainer.handleRestError);
                        }
                    }else{
                        ErrorContainer.setErrorCode('Niet alle velden zijn correct ingevuld');
                    }

                };

            }]

        };
    });