'use strict';

angular.module('com.bendani.bibliomania.wizard.oeuvre.controller', ['com.bendani.bibliomania.oeuvre.model', 'com.bendani.bibliomania.error.container', 'com.bendani.bibliomania.author.model'])
    .controller('WizardOeuvreController', ['$scope', '$routeParams', 'Oeuvre', 'Author', 'ErrorContainer', function ($scope, $routeParams, Oeuvre, Author, ErrorContainer) {

        function init(){
            $scope.data = {};
            $scope.data.author = Author.getByBook({ id: $routeParams.modelId });
            $scope.data.oeuvre = Oeuvre.getByBook({ id: $routeParams.modelId });
        }

        $scope.linkLabel = function(oeuvreItem){
            if(isBookLinkedToOeuvreItem(oeuvreItem)){
                return 'label-success';
            }else if(oeuvreItem.linkedBooks.length > 0){
                return 'label-warning';
            }
            return 'label-danger';
        };

        $scope.linkText = function(oeuvreItem){
            if(isBookLinkedToOeuvreItem(oeuvreItem)){
                return 'LINKED';
            }else if(oeuvreItem.linkedBooks.length > 0){
                return 'LINKED TO OTHER BOOK';
            }
            return 'UNLINKED';
        };

        $scope.linkBookToOeuvreItem = function(oeuvreItem){
            var bookId = parseInt($routeParams.modelId);
            var bookLinked = isBookLinkedToOeuvreItem(oeuvreItem);
            unlinkAllBooks(bookId);
            if(!bookLinked){
                oeuvreItem.linkedBooks.push(bookId);
            }
            Oeuvre.update({id: oeuvreItem.id}, oeuvreItem, function(){
                console.log('update of oeuvreItem successful');
            }, ErrorContainer.handleRestError);
        };

        $scope.addOeuvreItems = function(){
            var itemsToAdd = [];
            if($scope.validateOeuvreList($scope.container.model.oeuvreItemsToAdd)){
                var lines = $scope.container.model.oeuvreItemsToAdd.split('\n');
                for(var i = 0; i<lines.length; i++){
                    var obj = lines[i];

                    var splitString = obj.split(" - ");
                    var publicationYear = splitString[0];
                    var title = splitString[1];

                    itemsToAdd.push({
                        publicationYear: publicationYear,
                        title: title,
                        authorId: $scope.data.author.id
                    });
                }
            }

            Oeuvre.createItems(itemsToAdd, function(){
                $scope.container.model.oeuvreItemsToAdd = undefined;
                $scope.data.oeuvre = Oeuvre.getByBook({ id: $routeParams.modelId });
            }, ErrorContainer.handleRestError);
        };

        $scope.deleteOeuvreItem = function(oeuvreItem){
            Oeuvre.delete({ id: oeuvreItem.id}, function(){
                $scope.data.oeuvre = Oeuvre.getByBook({ id: $routeParams.modelId });
            }, ErrorContainer.handleRestError);
        };

        function unlinkAllBooks(bookId){
            for(var i =0; i< $scope.data.oeuvre.length; i++){
                var item = $scope.data.oeuvre[i];
                var index = item.linkedBooks.indexOf(bookId);
                if(index > -1){
                    item.linkedBooks.splice(index, 1);
                }
            }
        }

        function isBookLinkedToOeuvreItem(oeuvreItem){
            var bookId = parseInt($routeParams.modelId);
            return oeuvreItem.linkedBooks.indexOf(bookId) > -1;
        }

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

        init();
    }]);