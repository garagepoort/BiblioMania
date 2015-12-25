angular
    .module('com.bendani.bibliomania.image.card.directive', [])
    .directive('imageCard', function (){
        return {
            scope: {
                model: '=',
                warnings: '=',
                onEditClick: '&',
                onImageClick: '&',
                showEditButton: '@'
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/image-card-directive.html",
            link: function ($scope, element) {
                if($scope.model.image === undefined){
                    $scope.imageStyle = "width: 142px; height: 214px; background: url('images/questionCover.png'); background-position:  0px -0px;margin-bottom: 0px;";
                }else{
                    $scope.imageStyle = "width: " + $scope.model.image.imageWidth +"px; height: " + $scope.model.image.imageHeight + "px; background: url('" +$scope.model.image.image +"'); background-position:  0px -"+ $scope.model.image.spritePointer +"px; margin-bottom: 0px;";
                }

                if($scope.showEditButton === 'true'){
                    $(element).find(".ic_container").capslide({
                        showcaption: false,
                        overlay_bgcolor: ""
                    });
                }

                $(element).find('[data-toggle="tooltip"]').tooltip();
            }
        };
    });
