angular.module('com.bendani.bibliomania.add.oeuvre.items.modal', ['com.bendani.bibliomania.oeuvre.model', 'com.bendani.bibliomania.error.container', 'angular-growl'])
    .controller('AddOeuvreItemsController', ['$scope', 'Oeuvre', 'ErrorContainer', 'growl', function($scope, Oeuvre, ErrorContainer, growl){

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
                        authorId: $scope.model.id
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