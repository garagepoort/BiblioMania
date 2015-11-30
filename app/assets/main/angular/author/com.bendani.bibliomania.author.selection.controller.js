angular.module('com.bendani.bibliomania.author.selection.controller', ['com.bendani.bibliomania.author.model', 'com.bendani.bibliomania.error.container'])
    .controller('AuthorSelectionController', ['$scope', 'Author', 'ErrorContainer', function($scope, Author, ErrorContainer){

        function init(){
            $scope.authorSelectionModal = {};
            $scope.authorSelectionModal.data = {};
            $scope.authorSelectionModal.data.authors = Author.query(function(){}, ErrorContainer.handleRestError);
            $scope.authorSelectionModal.searchAuthorsQuery = '';
            $scope.authorSelectionModal.predicate = 'name.lastname';
            $scope.authorSelectionModal.reverse = false;
        }

        $scope.selectAuthor = function(author){
            $scope.$close(author);
        };

        $scope.search = function(item){
            if ( (item.name.firstname.toLowerCase().indexOf($scope.authorSelectionModal.searchAuthorsQuery) !== -1)
                || (item.name.lastname.toLowerCase().indexOf($scope.authorSelectionModal.searchAuthorsQuery) !== -1) ){
                return true;
            }
            return false;
        };

        $scope.order = function(predicate) {
            $scope.authorSelectionModal.reverse = ($scope.authorSelectionModal.predicate === predicate) ? !$scope.authorSelectionModal.reverse : false;
            $scope.authorSelectionModal.predicate = predicate;
        };

        init();
    }]);