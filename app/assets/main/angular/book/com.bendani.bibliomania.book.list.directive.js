angular
    .module('com.bendani.bibliomania.book.list.directive', [])
    .directive('bookList', function (){
        return {
            scope: {
                books: '='
            },
            templateUrl: "../BiblioMania/views/partials/book/book-list-directive.html",
            controller: ['$scope', '$location', function($scope, $location) {
                $scope.searchBooksQuery = '';

                $scope.goToBookDetails = function(book){
                    $location.path('/book-details/' + book.id);
                };

                $scope.search = function(item){
                    if (item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1 ||
                        item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1
                    ){
                        return true;
                    }
                    return false;
                };
            }]
        };
    });
