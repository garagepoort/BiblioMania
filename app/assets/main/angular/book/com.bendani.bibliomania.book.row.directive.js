angular
    .module('com.bendani.bibliomania.book.row.directive', [
        'com.bendani.bibliomania.reading.date.modal.service',
        'com.bendani.bibliomania.book.overview.service'])
    .directive('bookRow', function (){
        return {
            scope: {
                book: '='
            },
            templateUrl: "../BiblioMania/views/partials/book/book-row-directive.html",
            controller: ['$scope', '$location', 'BookOverviewService', function($scope, $location, BookOverviewService) {
                $scope.warnings = BookOverviewService.getBookWarnings($scope.book);

                $scope.goToBookDetails = function(){
                    $location.path('/book-details/' + $scope.book.id);
                };

                $scope.openDetails = function(){
                    BookOverviewService.selectBook($scope.book);
                };

            }],
            link: function ($scope, element) {
                $(element).find('[data-toggle="tooltip"]').tooltip();
            }
        };
    });
