angular.module('com.bendani.bibliomania.author.creation.modal.service', ['com.bendani.bibliomania.create.author.directive', 'com.bendani.bibliomania.error.container'])
    .provider('AuthorCreationModalService', function AuthorCreationModalServiceProvider(){
        function AuthorCreationModalService($uibModal) {
            var service = {
                show: function(onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/author/create-author-modal.html',
                        windowClass: 'create-author-dialog'
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new AuthorCreationModalService($uibModal);
        }];
    })
    .controller('AuthorCreationModalController', ['$scope', 'Author', 'ErrorContainer', function($scope, Author, ErrorContainer){

        function init(){
            $scope.data = {};
            $scope.data.onSaveAuthor = function(authorId){
                Author.get({id: authorId}, function(author){
                    $scope.$close(author);
                }, ErrorContainer.handleRestError);
            };
        }
        init();
    }]);