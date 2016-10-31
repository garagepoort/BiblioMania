angular
    .module('com.bendani.bibliomania.image.card.directive', [])
    .directive('imageCard', ['$timeout', function ($timeout) {
        return {
            scope: {
                model: '=',
                options: '=',
                backupText: '@',
                warnings: '=',
                onEditClick: '&',
                onImageClick: '&',
                useSpriteImage: '=?',
                showEditButton: '@'
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/image-card-directive.html",
            link: function ($scope, element) {

                $scope.overlayVisible = false;

                $scope.onClick = function(){
                    $scope.overlayVisible = true;
                    $timeout(function () { $scope.overlayVisible = false; }, 500);
                    $scope.onImageClick($scope.model);
                };

                $scope.showOverlayButton = function(){
                    return $scope.showEditButton && $scope.overlayVisible;
                };

                $scope.wrapperStyle = "width: 142px; height: 226px;";
                $scope.imageStyle = "width: 142px; height: 226px; background-position:  0px -0px; margin-bottom: 0px;";
                $scope.overlayStyle = "width: 142px; height: 226px;";

                if(isSpriteImage() || $scope.model.image){
                    var imageWidth = $scope.model.spriteImage.imageWidth;
                    var imageHeight = $scope.model.spriteImage.imageHeight;

                    $scope.wrapperStyle = "width: " + imageWidth + "px; height: " + imageHeight + "px;";
                    $scope.overlayStyle = $scope.wrapperStyle;
                    $scope.imageStyle = $scope.wrapperStyle + "background: url('" + $scope.model.image + "');";

                    if(isSpriteImage()){
                        $scope.imageStyle = $scope.wrapperStyle + "background: url('" + $scope.model.spriteImage.image + "'); background-position:  0px -" + $scope.model.spriteImage.spritePointer + "px; margin-bottom: 0px;";
                        $scope.overlayStyle = $scope.wrapperStyle + "margin-bottom: 0px;";
                    }
                }

                function isSpriteImage() {
                    return $scope.useSpriteImage && $scope.model.spriteImage;
                }

                $(element).find('[data-toggle="tooltip"]').tooltip();
            }
        };
    }]);
