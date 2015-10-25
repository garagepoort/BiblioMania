angular
    .module('com.bendani.bibliomania.book.card.directive', [])
    .directive('bookCard', function (){
        return {
            scope: true,
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-card-directive.html",
            controller: ['$scope', function($scope) {
                $scope.imageStyle = getImageStyle($scope.book.imageHeight, $scope.book.imageWidth, $scope.book.coverImage, $scope.book.spritePointer);
            }],
            link: function ($scope, element) {
                $(element).capslide({
                    showcaption: false,
                    overlay_bgcolor: ""
                });

                $(element).find('[data-toggle="tooltip"]').tooltip();

                $(element).click(function (event) {
                    $scope.$parent.setSelectedBookId($scope.book.id);
                });


            }
        };
    });