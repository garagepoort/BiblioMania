angular.module('com.bendani.bibliomania.edit.serie.modal.service', [
    'com.bendani.bibliomania.error.container',
    'com.bendani.bibliomania.serie.model',
    'com.bendani.bibliomania.book.model'
    ])
    .provider('EditSerieModalService', function EditSerieModalServiceProvider(){
        function EditSerieModalService($uibModal) {
            var service = {
                show: function(serie, type, onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/book/edit-serie-modal.html',
                        controller: 'EditSerieModalController',
                        windowClass: 'edit-book-serie-dialog',
                        resolve: {
                            serieModel: serie,
                            type: function(){
                                return type;
                            }
                        }
                    });

                    modalInstance.result.then(onResultFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new EditSerieModalService($uibModal);
        }];
    })
    .controller('EditSerieModalController', ['$scope', 'Serie', 'PublisherSerie', 'ErrorContainer', 'serieModel', 'growl', 'Book', 'type', function($scope, Serie, PublisherSerie, ErrorContainer, serieModel, growl, Book, type){
        var client;
        function init(){
            $scope.model = serieModel;
            $scope.data = {};
            $scope.data.books = Book.query(function(){}, ErrorContainer.handleRestError);
            $scope.submitAttempted = false;
            $scope.searchAllBooksQuery = '';
            $scope.searchModelBooksQuery = '';

            client = type === 'book_serie' ? Serie : PublisherSerie;
        }

        $scope.submit = function(valid){
            $scope.submitAttempted = true;
            if(valid){
                client.update($scope.model, function(){
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
            client.removeBook({id: $scope.model.id}, {bookId: book.id}, function () {
                growl.addSuccessMessage("Boek verwijderd");
                var index = $scope.model.books.indexOf(book);
                if(index > -1){
                    $scope.model.books.splice(index, 1);
                }
            }, ErrorContainer.handleRestError);
        };

        $scope.addBookToSerie = function(book){
            client.addBook({id: $scope.model.id}, {bookId: book.id}, function () {
                growl.addSuccessMessage("Boek toegevoegd");
                $scope.model.books.push(book);
            }, ErrorContainer.handleRestError);
        };

        init();
    }]);