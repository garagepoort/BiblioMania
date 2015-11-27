angular.module('com.bendani.bibliomania.book.details.ui', ['com.bendani.bibliomania.book.model', 'com.bendani.bibliomania.error.container'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/book-details/:id', {
                templateUrl: '../BiblioMania/views/partials/book/book-detail.html',
                controller: 'BookDetailsController'
            });
    }])
    .controller('BookDetailsController', ['$scope', '$routeParams', 'Book','ErrorContainer',function($scope, $routeParams, Book, ErrorContainer){
        function init(){
            $scope.$parent.title = "Boek detail";
            $scope.book = Book.get({id: $routeParams.id}, function(book){
                $scope.$parent.title = book.title;
            }, ErrorContainer.handleRestError);
        }

        init();
    }]);