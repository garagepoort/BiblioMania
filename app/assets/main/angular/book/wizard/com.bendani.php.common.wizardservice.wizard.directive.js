angular
    .module('com.bendani.php.common.wizardservice.wizard.directive', ['ngRoute', 'com.bendani.bibliomania.error.container'])
    .directive('wizard', function (){
        return {
            scope: {
                steps: "=",
                currentStep: "@",
                progressStep: "@",
                modelId: "@",
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/wizard/wizard-directive.html",
            controller: ['$rootScope', '$scope', '$routeParams', '$http', 'ErrorContainer',function($rootScope, $scope, $routeParams, $http, ErrorContainer) {

                function init(){
                    $scope.container = {};
                    $scope.container.model = {};
                    $scope.$watch('steps', function(newValue){
                        if($scope.steps != undefined){
                            var url = $rootScope.baseUrl.concat($scope.steps[$scope.currentStep].modelUrl);
                            if($scope.modelId !== undefined){
                                url = url.concat("/").concat($scope.modelId);
                            }
                            $http.get(url).then(
                                function(response){
                                    $scope.container.model = response.data;
                                }, ErrorContainer.handleRestError);
                        }
                    })
                }

                init();
            }]
        };
    });