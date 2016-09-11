angular.module('com.bendani.bibliomania.edit.serie.modal.service', [
    'com.bendani.bibliomania.serie.model',
    'com.bendani.bibliomania.book.model'
    ])
    .provider('EditSerieModalService', function EditSerieModalServiceProvider(){
        function EditSerieModalService($uibModal) {
            var service = {
                show: function(serie, filters, client, onResultFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/book/edit-serie-modal.html',
                        controller: 'EditSerieModalController',
                        windowClass: 'edit-book-serie-dialog',
                        resolve: {
                            serieModel: function(){
                                return serie;
                            },
                            client: function(){
                                return client;
                            },
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
            return new EditSerieModalService($uibModal);
        }];
    })
    .controller('EditSerieModalController', ['$scope', 'ErrorContainer', 'serieModel', 'growl', 'Book', 'client', 'filters', function($scope, ErrorContainer, serieModel, growl, Book, client, filters){
        function init(){
            $scope.model = serieModel;
            $scope.data = {};
            $scope.submitAttempted = false;
            $scope.searchAllBooksQuery = '';
            $scope.searchModelBooksQuery = '';

            Book.searchAllBooks(filters, function(books){
                $scope.data.books = books;
            }, ErrorContainer.handleRestError);
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
            if(item.subtitle === undefined || item.subtitle === null){
                item.subtitle = "";
            }

            var searchString = $scope.searchAllBooksQuery.toLowerCase();
            if ((item.title.toLowerCase().indexOf(searchString) !== -1)
                || (item.subtitle.toLowerCase().indexOf(searchString) !== -1)
                || (item.mainAuthor.toLowerCase().indexOf(searchString) !== -1)) {
                return true;
            }
            return false;
        };
        $scope.searchModelBooks = function(item){
            if(item.subtitle === undefined || item.subtitle === null){
                item.subtitle = "";
            }

            var searchString = $scope.searchModelBooksQuery.toLowerCase();
            if ((item.title.toLowerCase().indexOf(searchString) !== -1)
                || (item.subtitle.toLowerCase().indexOf(searchString) !== -1)) {
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