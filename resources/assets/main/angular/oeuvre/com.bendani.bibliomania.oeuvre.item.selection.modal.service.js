'use strict';

angular.module('com.bendani.bibliomania.oeuvre.item.selection.modal.service', ['com.bendani.bibliomania.author.model'])
    .provider('OeuvreItemSelectionModalService', function OeuvreItemSelectionModalServiceProvider(){
        function OeuvreItemSelectionModalService($uibModal) {
            var service = {
                show: function(authors, onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/oeuvre/select-oeuvre-item-modal.html',
                        controller: 'OeuvreItemSelectionController',
                        windowClass: 'select-oeuvre-item-dialog',
                        resolve: {
                            authors: function(){
                                return authors;
                            }
                        }
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new OeuvreItemSelectionModalService($uibModal);
        }];
    })
    .controller('OeuvreItemSelectionController', ['$scope', 'Author', 'ErrorContainer', 'authors', function($scope, Author, ErrorContainer, authors){
        $scope.authors = authors;
        $scope.selectedAuthor = authors[0];
        $scope.searchOeuvreItemQuery = '';
        getOeuvreFromSelectedAuthor();

        $scope.selectAuthor = function(author){
            $scope.selectedAuthor = author;
            getOeuvreFromSelectedAuthor();
        };

        $scope.selectOeuvreItem = function(oeuvreItem){
            $scope.$close(oeuvreItem);
        };

        $scope.search = function(item){
            if (item.title.toLowerCase().indexOf($scope.searchOeuvreItemQuery) !== -1 ){
                return true;
            }
            return false;
        };

        function getOeuvreFromSelectedAuthor() {
            $scope.oeuvre = Author.oeuvre({id: $scope.selectedAuthor.id}, function () {}, ErrorContainer.handleRestError);
        }
    }]);