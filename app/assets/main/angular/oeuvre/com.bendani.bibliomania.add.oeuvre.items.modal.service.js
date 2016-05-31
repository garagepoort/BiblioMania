angular.module('com.bendani.bibliomania.add.oeuvre.items.modal.service', ['com.bendani.bibliomania.oeuvre.model', 'angular-growl'])
    .provider('AddOeuvreItemsModalService', function AddOeuvreItemsModalServiceProvider(){
        function AddOeuvreItemsModalService($uibModal) {
            var service = {
                show: function(authorId, onSuccessFunction) {

                    var modalInstance = $uibModal.open({
                        templateUrl: '../BiblioMania/views/partials/oeuvre/add-oeuvre-items-modal.html',
                        controller: 'AddOeuvreItemsController',
                        resolve: {
                            authorId: function(){
                                return authorId;
                            }
                        }
                    });

                    modalInstance.result.then(onSuccessFunction);
                }
            };
            return service;
        }

        this.$get = ['$uibModal', function ($uibModal) {
            return new AddOeuvreItemsModalService($uibModal);
        }];
    })
    .controller('AddOeuvreItemsController', ['$scope', 'Oeuvre', 'authorId', 'ErrorContainer', 'growl', function($scope, Oeuvre, authorId, ErrorContainer, growl){

        $scope.addOeuvreItems = function(){
            var itemsToAdd = [];
            if($scope.validateOeuvreList($scope.oeuvreItemsToAdd)){
                var lines = $scope.oeuvreItemsToAdd.split('\n');
                for(var i = 0; i<lines.length; i++){
                    var obj = lines[i];

                    var splitString = obj.split(" - ");
                    var publicationYear = splitString[0];
                    var title = splitString[1];

                    itemsToAdd.push({
                        publicationYear: publicationYear,
                        title: title,
                        authorId: authorId
                    });
                }
            }

            Oeuvre.createItems(itemsToAdd, function(){
                growl.addSuccessMessage("Oeuvre items toegevoegd");
                $scope.$close();
            }, ErrorContainer.handleRestError);
        };

        $scope.validateOeuvreList = function (value) {
            if (value !== null && value !== undefined && value !== "") {
                var lines = value.split('\n');
                for(var i = 0; i<lines.length; i++){
                    var obj = lines[i];

                    var splitString = obj.split(" - ");
                    if (splitString.length < 2) {
                        return false;
                    }

                    var year = splitString[0];
                    var title = splitString[1];
                    if (!title) {
                        return false;
                    }
                    if (year.length > 4) {
                        return false;
                    }
                }
            }

            return true;
        };
    }]);