angular.module('com.bendani.bibliomania.edit.book.serie.modal.service', [
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.serie.model',
    'com.bendani.bibliomania.book.model'
    ])
    .provider('EditBookSerieModalService', function EditBookSerieModalServiceProvider(){
        function EditBookSerieModalService($uibModal) {
            var service = {
                show: function(serie, onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/book/edit-book-serie-modal.html',
                        controller: 'EditBookSerieModalController',
                        windowClass: 'edit-book-serie-dialog',
                        resolve: {
                            serieModel: serie
                        }
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new EditBookSerieModalService($uibModal);
        }];
    })
    .controller('EditBookSerieModalController', ['$scope', 'Serie', 'ErrorContainer', 'serieModel', 'growl', 'Book', function($scope, Serie, ErrorContainer, serieModel, growl, Book){

        function init(){
            $scope.model = serieModel;
            $scope.data = {};
            $scope.data.books = Book.query(function(){}, ErrorContainer.handleRestError);
            $scope.submitAttempted = false;
            $scope.searchAllBooksQuery = '';
            $scope.searchModelBooksQuery = '';
        }

        $scope.submit = function(valid){
            $scope.submitAttempted = true;
            if(valid){
                Serie.update($scope.model, function(){
                    growl.addSuccessMessage('Serie opgeslagen');
                }, ErrorContainer.handleRestError);
            }
        };

        $scope.searchAllBooks = function(item){
            if ((item.title.toLowerCase().indexOf($scope.searchAllBooksQuery) !== -1)){
                return true;
            }
            return false;
        };
        $scope.searchModelBooks = function(item){
            if ((item.title.toLowerCase().indexOf($scope.searchModelBooksQuery) !== -1)){
                return true;
            }
            return false;
        };

        $scope.removeBookFromSerie = function(book){
            Serie.removeBook({id: $scope.model.id}, {bookId: book.id}, function () {
                growl.addSuccessMessage("Boek verwijderd");
                var index = $scope.model.books.indexOf(book);
                if(index > -1){
                    $scope.model.books.splice(index, 1);
                }
            }, ErrorContainer.handleRestError);
        };

        $scope.addBookToSerie = function(book){
            Serie.addBook({id: $scope.model.id}, {bookId: book.id}, function () {
                growl.addSuccessMessage("Boek toegevoegd");
                $scope.model.books.push(book);
            }, ErrorContainer.handleRestError);
        };

        init();
    }]);