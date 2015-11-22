angular.module('com.bendani.bibliomania.author.selection.controller', [])
    .controller('AuthorSelectionController', ['$scope', 'Author', 'ErrorContainer', function($scope, Author, ErrorContainer){

        function init(){
            $scope.data.authors = Author.query(function(){}, ErrorContainer.handleRestError);
            $scope.searchAuthorsQuery = '';
        }

        $scope.selectAuthor = function(author){
            $scope.$close(author);
        };

        $scope.search = function(item){
            if ( (item.name.firstname.toLowerCase().indexOf($scope.searchAuthorsQuery) !== -1)
                || (item.name.lastname.toLowerCase().indexOf($scope.searchAuthorsQuery) !== -1) ){
                return true;
            }
            return false;
        };

        init();
    }]);