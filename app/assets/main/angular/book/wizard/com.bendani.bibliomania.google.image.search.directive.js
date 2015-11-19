angular
    .module('com.bendani.bibliomania.google.image.search.directive', [])
    .factory('GoogleImage', ['$resource', function ($resource) {

        return $resource('https://www.googleapis.com/customsearch/v1', {
            cx: '003701006117915782863%3Agrbhoeigwrg',
            key: 'AIzaSyBPkSNgxg9ZjRgYnS0Fj6fZ9xw-Xn5l_pw',
            searchType: 'image',
            imgSize: 'medium',
            alt: 'json'
        }, {
            search: {
                method: 'GET',
                params: {
                    q: '@query'
                }
            }
        });
    }])
    .directive('googleImageSearch', function () {
        return {
            scope: {
                imageModel: "=ngModel",
                query: "@",
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/google-image-search-directive.html",
            controller: ['$scope', 'GoogleImage', function ($scope, GoogleImage) {

                function init() {
                    $scope.executeSearch();
                }

                $scope.executeSearch = function () {
                    GoogleImage.search({q: $scope.query}, function (data) {
                        $scope.images = data.items;
                    });
                };

                init();
            }]
        };
    });