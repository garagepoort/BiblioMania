angular.module('com.bendani.bibliomania.author.selection.modal.service', ['com.bendani.bibliomania.author.model'])
    .provider('AuthorSelectionModalService', function AuthorSelectionModalServiceProvider(){
        function AuthorSelectionModalService($uibModal) {
            var service = {
                show: function(onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/author/select-author-modal.html'
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new AuthorSelectionModalService($uibModal);
        }];
    })
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