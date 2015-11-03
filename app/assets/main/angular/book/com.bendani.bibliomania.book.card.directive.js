angular
    .module('com.bendani.bibliomania.book.card.directive', [])
    .directive('bookCard', function (){
        return {
            scope: true,
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-card-directive.html",
            controller: ['$scope', function($scope) {
            }],
            link: function ($scope, element) {
                $(element).find(".ic_container").capslide({
                    showcaption: false,
                    overlay_bgcolor: ""
                });

                $(element).find('[data-toggle="tooltip"]').tooltip();

                $(element).click(function (event) {
                    if($scope.$parent.isBookDetailPanelOpen() && $scope.$parent.getSelectedBookId() == $scope.book.id){
                        $scope.$parent.closeBookDetailPanel();
                    }else{
                        $scope.$parent.setSelectedBookId($scope.book.id);
                        $scope.$parent.openBookDetailPanel();
                    }
                });
            }
        };
    });