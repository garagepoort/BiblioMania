angular
    .module('com.bendani.bibliomania.book.card.directive', [])
    .directive('bookCard', function (){
        return {
            scope: true,
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-card-directive.html",
            controller: [function() {
            }],
            link: function ($scope, element) {
                if($scope.book.image === undefined){
                    $scope.bookImageStyle = "width: 142px; height: 214px; background: url('images/questionCover.png'); background-position:  0px -0px;margin-bottom: 0px;";
                }else{
                    $scope.bookImageStyle = "width: " + $scope.book.image.imageWidth +"px; height: " + $scope.book.image.imageHeight + "px; background: url('" +$scope.book.image.image +"'); background-position:  0px -"+ $scope.book.image.spritePointer +"px; margin-bottom: 0px;";
                }

                $(element).find(".ic_container").capslide({
                    showcaption: false,
                    overlay_bgcolor: ""
                });

                $(element).find('[data-toggle="tooltip"]').tooltip();

                $(element).click(function () {
                    if($scope.$parent.isBookDetailPanelOpen() && $scope.$parent.getSelectedBookId() === $scope.book.id){
                        $scope.$parent.closeBookDetailPanel();
                    }else{
                        $scope.$parent.setSelectedBookId($scope.book.id);
                        $scope.$parent.openBookDetailPanel();
                    }
                });
            }
        };
    });
