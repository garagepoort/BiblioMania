'use strict';

angular.module('com.bendani.bibliomania.edit.book.ui', ['ngTagsInput',
    'angularBootstrapNavTree',
    'php.common.uiframework.date',
    'com.bendani.bibliomania.image.fallback',
    'com.bendani.bibliomania.genre.model',
    'com.bendani.bibliomania.tag.model',
    'com.bendani.bibliomania.title.panel',
    'com.bendani.bibliomania.country.model',
    'com.bendani.bibliomania.google.api.book.model',
    'com.bendani.bibliomania.publisher.model',
    'com.bendani.bibliomania.serie.model',
    'com.bendani.bibliomania.publisher.serie.model',
    'com.bendani.bibliomania.book.model',
    'com.bendani.bibliomania.author.model',
    'com.bendani.bibliomania.image.selection.controller',
    'com.bendani.bibliomania.language.model'])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/edit-book/:id', {
            templateUrl: '../BiblioMania/views/partials/book/edit-book.html',
            controller: 'CreateBookController',
            resolve: {
                bookModel: ['Book', '$route', 'ErrorContainer', function (Book, $route, ErrorContainer) {
                    return Book.get({id: $route.current.params.id}, function () {}, ErrorContainer.handleRestError);
                }],
                onSave: ['Book', '$route', 'ErrorContainer', 'growl', '$location', function (Book, $route, ErrorContainer, growl, $location) {
                    return function (model) {
                        Book.update(model, function () {
                            $location.path('/book-details/' + model.id);
                            growl.addSuccessMessage('Boek opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }],
                initFunction: function(){ return function(){}; }
            }
        });
        $routeProvider.when('/create-book', {
            templateUrl: '../BiblioMania/views/partials/book/edit-book.html',
            controller: 'CreateBookController',
            resolve: {
                bookModel: function () {
                    return {};
                },
                onSave: ['Book', '$route', 'ErrorContainer', 'growl', '$location', function (Book, $route, ErrorContainer, growl, $location) {
                    return function (model) {
                        Book.save(model, function(response){
                            $location.path('/book-details/' + response.id);
                            growl.addSuccessMessage('Boek opgeslagen');
                        }, ErrorContainer.handleRestError);
                    };
                }],
                initFunction: function(){ return function(){}; }
            }
        });
    }])
    .controller('CreateBookController', ['$scope', 'Genre', 'Tag', 'Country', 'Publisher', 'Language', 'Book', 'Author', 'Serie', 'PublisherSerie',
                'ErrorContainer', '$uibModal', '$location', 'TitlePanelService', 'bookModel', 'onSave', 'initFunction', 'GoogleApiBook',
        function ($scope, Genre, Tag, Country, Publisher, Language, Book, Author, Serie, PublisherSerie, ErrorContainer, $uibModal, $location, TitlePanelService, bookModel, onSave, initFunction, GoogleApiBook) {

            function init(){
                TitlePanelService.setTitle('Boek');

                $scope.model = bookModel;
                initFunction();

                if($scope.model.$promise){
                    $scope.model.$promise.then(function(){
                        if(!$scope.model.publicationDate){
                            $scope.model.publicationDate = {};
                        }

                        var preferredAuthor = _.findWhere($scope.model.authors, {preferred: true});
                        if(preferredAuthor){
                            Author.get({id: preferredAuthor.id}, function(author){
                                setSelectedAuthor(author);
                            }, ErrorContainer.handleRestError);
                        }
                    });
                }

                $scope.genreTree = {};

                $scope.data = {};
                $scope.data.genres = Genre.query(function(){}, ErrorContainer.handleRestError);
                $scope.data.tags = Tag.query(function(){}, ErrorContainer.handleRestError);
                $scope.data.countries = Country.query(function(){}, ErrorContainer.handleRestError);
                $scope.data.publishers = Publisher.query(function(){}, ErrorContainer.handleRestError);
                $scope.data.languages = Language.query(function(){}, ErrorContainer.handleRestError);
                $scope.data.series = Serie.query(function(){}, ErrorContainer.handleRestError);
                $scope.data.publisherSeries = PublisherSerie.query(function(){}, ErrorContainer.handleRestError);

                $scope.submitAttempted = false;

                $scope.$watch('model.title', searchGoogleBookByIsbnAndTitle);
                $scope.$watch('model.isbn', searchGoogleBookByIsbnAndTitle);
            }

            $scope.selectGenre = function(branch){
                $scope.model.genre = branch.label;
            };

            $scope.searchTags = function($query){
                return $scope.data.tags.filter(function (item) {
                    return item.text.toLowerCase().indexOf($query) !== -1;
                });
            };

            $scope.searchBookImage = function () {
                if ($scope.model !== undefined) {
                    $scope.bookImageQuery = $scope.model.title + " " + $scope.model.isbn;
                }
            };

            $scope.openSelectImageDialog = function(){
                $scope.imageSelectModal = {};
                var searchQuery = '';

                if($scope.model.title){ searchQuery = searchQuery + ' ' + $scope.model.title; }
                if($scope.model.isbn){ searchQuery = searchQuery + ' ' + $scope.model.isbn; }
                if($scope.data.selectedAuthor){ searchQuery = searchQuery + ' ' + $scope.data.selectedAuthor.name.lastname; }

                $scope.imageSelectModal.searchQuery = searchQuery;

                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/select-image-modal.html',
                    scope: $scope,
                    windowClass: 'select-image-modal'
                });

                modalInstance.result.then(function (image) {
                    $scope.model.imageUrl = image;
                    $scope.model.image = image;
                });
            };

            $scope.showSelectAuthorDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/author/select-author-modal.html',
                    scope: $scope
                });

                modalInstance.result.then(function (author) {
                    $scope.data.selectedAuthor = author;
                    $scope.data.selectedAuthorImage = author.image;
                    $scope.model.preferredAuthorId = author.id;
                });
            };


            $scope.showCreateAuthorDialog = function () {
                var modalInstance = $uibModal.open({
                    templateUrl: '../BiblioMania/views/partials/author/create-author-modal.html',
                    scope: $scope,
                    windowClass: 'create-author-dialog'
                });

                modalInstance.result.then(function (author) {
                    setSelectedAuthor(author);
                });
            };

            $scope.submitForm = function(formValid){
                $scope.submitAttempted = true;
                if(isFormValid(formValid)){
                    onSave($scope.model);
                }
            };

            $scope.copyGoogleBookTitleToModel = function(){
                $scope.model.title = $scope.googleBook.title;
            };

            $scope.copyGoogleBookSubtitleToModel = function(){
                $scope.model.subtitle = $scope.googleBook.subtitle;
            };

            $scope.copyGoogleBookIsbnToModel = function(){
                if($scope.googleBook && $scope.googleBook.industryIdentifiers.length > 0){
                    var isbn = $scope.getGoogleBookIsbn();
                    if(isbn){
                        $scope.model.isbn = isbn;
                    }
                }
            };

            $scope.getGoogleBookIsbn = function(){
                if($scope.googleBook && $scope.googleBook.industryIdentifiers.length > 0){
                    var result = $scope.googleBook.industryIdentifiers.filter(function( obj ) {
                        return obj.type === "ISBN_13";
                    });
                    if(result.length > 0){
                        return result[0].identifier;
                    }
                }
            };

            $scope.copyGoogleBookDescriptionToModel = function(){
                $scope.model.summary = $scope.googleBook.description;
            };

            $scope.copyGoogleBookPagesToModel = function(){
                $scope.model.pages = $scope.googleBook.pageCount;
            };

            $scope.copyGoogleBookPublicationDateToModel = function(){
                if($scope.googleBook.publishedDate){
                    var splitDate = $scope.googleBook.publishedDate.split("-");
                    $scope.model.publicationDate.year = undefined;
                    $scope.model.publicationDate.month = undefined;
                    $scope.model.publicationDate.day = undefined;
                    if(splitDate.length >= 1){
                        $scope.model.publicationDate.year = parseInt(splitDate[0]);
                    }
                    if(splitDate.length >= 3){
                        $scope.model.publicationDate.month = parseInt(splitDate[1]);
                    }
                    if(splitDate.length >= 3){
                        $scope.model.publicationDate.day = parseInt(splitDate[2]);
                    }
                }
            };

            function isFormValid(formValid){
                var valid = true;
                if(!formValid){
                    ErrorContainer.setErrorCode('Niet alle velden zijn correct ingevuld.');
                    valid = false;
                }
                if($scope.model.preferredAuthorId === undefined){
                    ErrorContainer.setErrorCode('Geen auteur geselecteerd');
                    valid = false;
                }
                return valid;
            }

            function setSelectedAuthor(author){
                $scope.data.selectedAuthor = author;
                $scope.data.selectedAuthorImage = author.image;
                $scope.model.preferredAuthorId = author.id;
            }

            function searchGoogleBookByIsbnAndTitle(){
                return GoogleApiBook.get({ 'q': 'isbn:'+ $scope.model.isbn}, function(result){
                    if(result && result.items && result.items.length > 0){
                        $scope.googleBook = result.items[0].volumeInfo;
                    }else{
                        searchGoogleBookByTitle();
                    }
                }, ErrorContainer.handleRestError);
            }

            function searchGoogleBookByTitle(){
                GoogleApiBook.get({ 'q': 'intitle:'+ $scope.model.title}, function(result){
                    if(result && result.items && result.items.length > 0){
                        $scope.googleBook = result.items[0].volumeInfo;
                    }
                }, ErrorContainer.handleRestError);
            }

            init();
    }]);