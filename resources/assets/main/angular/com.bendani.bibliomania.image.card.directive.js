angular
    .module('com.bendani.bibliomania.image.card.directive', [])
    .directive('imageCard', function () {
        return {
            scope: {
                model: '=',
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
                $scope.imageStyle = "width: 142px; height: 214px; background: url('images/questionCover.png'); background-position:  0px -0px;margin-bottom: 0px;";
                if ($scope.useSpriteImage && $scope.model.spriteImage) {
                    $scope.imageStyle = "width: " + $scope.model.spriteImage.imageWidth + "px; height: " + $scope.model.spriteImage.imageHeight + "px; background: url('" + $scope.model.spriteImage.image + "'); background-position:  0px -" + $scope.model.spriteImage.spritePointer + "px; margin-bottom: 0px;";
                } else if ($scope.model.image) {
                    $scope.imageStyle = "width: " + $scope.model.spriteImage.imageWidth + "px; height: " + $scope.model.spriteImage.imageHeight + "px; background: url('" + $scope.model.image + "');";
                }

                if ($scope.showEditButton === 'true') {
                    $(element).find(".ic_container").capslide({
                        showcaption: false,
                        overlay_bgcolor: ""
                    });
                }

                $(element).find('[data-toggle="tooltip"]').tooltip();
            }
        };
    });
