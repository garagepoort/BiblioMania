angular.module('com.bendani.bibliomania.author.creation.modal.controller', ['com.bendani.bibliomania.create.author.directive', 'com.bendani.bibliomania.error.container'])
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