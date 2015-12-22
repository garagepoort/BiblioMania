angular
    .module('com.bendani.bibliomania.book.card.directive', ['com.bendani.bibliomania.info.container', 'com.bendani.bibliomania.reading.date.modal.service'])
    .directive('bookCard', function (){
        return {
            scope: true,
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-card-directive.html",
            controller: ['$scope', '$location', 'ReadingDateModalService', 'growl', 'DateService', function($scope, $location, ReadingDateModalService, growl, DateService) {
                addWarnings();

                $scope.goToBookDetails = function(){
                    $location.path('/book-details/' + $scope.book.id);
                };

                $scope.openDetails = function(){
                    var selectedBook = $scope.$parent.getSelectedBook();
                    if($scope.$parent.isBookDetailPanelOpen() && selectedBook.id === $scope.book.id){
                        $scope.$parent.closeBookDetailPanel();
                    }else{
                        $scope.$parent.setSelectedBook($scope.book.id);
                    }
                };

                function addWarnings(){
                    $scope.warnings = [];
                    if($scope.book.personalBookInfoId){
                        if($scope.book.read){
                            $scope.warnings.push({
                                id: "bookread",
                                message: "Dit boek is gelezen",
                                icon: "images/check-circle-success.png",
                                handle: function(){
                                    openEditReadingDateModal(new Date());
                                }
                            });
                        }else{
                            $scope.warnings.push({
                                id: "bookread",
                                message: "Dit boek is niet gelezen",
                                icon: "images/check-circle-fail.png",
                                handle: function(){
                                    openEditReadingDateModal();
                                }
                            });
                        }
                    }
                }

                function openEditReadingDateModal(){
                    var date = {
                        date: DateService.dateToJsonDate(new Date())
                    };
                    ReadingDateModalService.show($scope.book.personalBookInfoId, function(){
                        $scope.book.read = true;
                        addWarnings();
                        growl.addSuccessMessage('Leesdatum opgeslagen');
                    }, date);

                }
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
            }
        };
    });
