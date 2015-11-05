angular
    .module('com.bendani.bibliomania.book.detail.directive', ['com.bendani.bibliomania.book.model'])
    .directive('bookDetail', [ 'Book', function (Book){
        return {
            scope: {
                bookDetailPanelOpen : "="
            },
            restrict: "E",
            replace: true,
            templateUrl: "../BiblioMania/views/partials/book/book-detail-directive.html",
            link: function ($scope, element) {
                $scope.bookSlidingPanel = new BorderSlidingPanel($(element), "right", 0);
                $scope.imageStyle = "";

                $scope.currencies = [];
                $scope.currencies['EUR'] = '€';
                $scope.currencies['USD'] = '$';
                $scope.currencies['PND'] = '£';

                $(element).on('click', function(event){
                    event.stopPropagation();
                });

                function retrieveFullBook(newValue) {
                    $scope.book = Book.get({id: newValue}, function (data) {
                        $scope.imageStyle = getImageStyle($scope.book.imageHeight, $scope.book.imageWidth, $scope.book.coverImage, $scope.book.spritePointer);
                        $scope.openBookDetail();
                    }, function (error) {
                        alert(error);
                    });
                }

                $scope.$parent.$watch('bookModel.selectedBookId', function(newValue) {
                    if(newValue){
                        retrieveFullBook(newValue);
                    }
                }, true);


                $scope.$watch('bookDetailPanelOpen', function(value){
                    if(value){
                        $scope.openBookDetail();
                    }else{
                        $scope.closeBookDetail();
                    }
                });

                $scope.closeBookDetail = function() {
                    $scope.bookSlidingPanel.close(function () {
                        $(element).removeClass('visible');
                    });
                }

                $scope.openBookDetail = function() {
                    $('#star-detail').raty({
                        score: $scope.book.personalBookInfo.rating,
                        number: 10,
                        readOnly: true,
                        path: '/BiblioMania/assets/lib/raty-2.7.0/lib/images'
                    });
                    $scope.bookSlidingPanel.open(function(){
                        $(element).addClass('visible');
                    });
                }
            }
        };
    }]);