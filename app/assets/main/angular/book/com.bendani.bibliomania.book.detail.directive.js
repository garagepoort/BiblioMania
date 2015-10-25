angular
    .module('com.bendani.bibliomania.book.detail.directive', ['com.bendani.bibliomania.book.model'])
    .directive('bookDetail', [ 'Book', function (Book){
        return {
            scope: true,
            restrict: "E",
            replace: true,
            templateUrl: "../BiblioMania/views/partials/book/book-detail-directive.html",
            link: function ($scope, element) {
                $scope.bookSlidingPanel = new BorderSlidingPanel($(element), "right", 0);
                $scope.imageStyle = "";

                $(element).on('click', function(event){
                    event.stopPropagation();
                });

                function retrieveFullBook(newValue) {
                    $scope.book = Book.get({id: newValue}, function (data) {
                        $scope.imageStyle = getImageStyle($scope.book.imageHeight, $scope.book.imageWidth, $scope.book.coverImage, $scope.book.spritePointer);
                        closeAndOpenBookDetail();
                    }, function (error) {
                        alert(error);
                    });
                }

                $scope.$parent.$watch('bookModel.selectedBookId', function(newValue) {
                    if(newValue){
                        retrieveFullBook(newValue);
                    }
                }, true);

                function closeAndOpenBookDetail() {
                    $scope.bookSlidingPanel.close(function () {
                        $(element).removeClass('visible');
                        openBookDetail();
                    });
                }

                function closeBookDetail() {
                    $scope.bookSlidingPanel.close(function () {
                        $(element).removeClass('visible');
                    });
                }

                function openBookDetail() {
                    $scope.bookSlidingPanel.open(function(){
                        $(element).addClass('visible');
                    });
                }
            }
        };
    }]);