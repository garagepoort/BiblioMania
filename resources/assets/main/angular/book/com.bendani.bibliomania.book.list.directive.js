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

                $scope.orderValues = [
                    {key: 'Titel', predicate: 'title', width: '30'},
                    {key: 'Ondertitel', predicate: 'subtitle', width: '30'}
                ];

                $scope.predicate = "title";
                $scope.reverseOrder = false;

                $scope.search = function(item){
                    return item.title.toLowerCase().indexOf($scope.searchBooksQuery) !== -1 ||
                        (item.subtitle && item.subtitle.toLowerCase().indexOf($scope.searchBooksQuery) !== -1);
                };
            }]
        };
    });
