angular.module('com.bendani.bibliomania.book.selection.modal.service', ['com.bendani.bibliomania.error.container'])
    .provider('BookSelectionModalService', function BookSelectionModalServiceProvider(){
        function BookSelectionModalService($uibModal) {
            var service = {
                show: function(filters, onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/book/select-book-modal.html',
                        controller: 'BookSelectionController',
                        resolve: {
                            filters: function(){
                                return filters;
                            }
                        }
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new BookSelectionModalService($uibModal);
        }];
    })
    .controller('BookSelectionController', ['$scope', 'Book', 'ErrorContainer', 'filters', function($scope, Book, ErrorContainer, filters){

        function init(){
            $scope.data = {};
            Book.searchAllBooks(filters, function (books) {
                $scope.data.books = books;
            }, ErrorContainer.handleRestError);
            $scope.searchBooksQuery = '';
        }

        $scope.selectBook = function(book){
            $scope.$close(book);
        };

        $scope.search = function(item){
            if ((item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1 ||
                item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1)){
                return true;
            }
            return false;
        };

        init();
    }]);