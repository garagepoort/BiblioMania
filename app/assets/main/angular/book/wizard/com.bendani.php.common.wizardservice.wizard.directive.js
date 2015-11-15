angular
    .module('com.bendani.php.common.wizardservice.wizard.directive', ['ngRoute', 'com.bendani.bibliomania.error.container', "com.bendani.bibliomania.dynamic.controller.directive"])
    .directive('wizard', function (){
        return {
            scope: {
                steps: "=",
                progressStep: "@",
                modelId: "@",
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/wizard/wizard-directive.html",
            controller: ['$rootScope', '$scope', '$controller', '$routeParams', '$http', 'ErrorContainer',function($rootScope, $scope, $controller, $routeParams, $http, ErrorContainer) {

                function init(){
                    $scope.container = {};
                    $scope.container.model = {};
                    $scope.$watch('steps', function(newValue){
                        if($scope.steps != undefined){
                            $scope.currentStep=$scope.steps[0];
                            $http.get(getStepUrl()).then(
                                function(response){
                                    $scope.container.model = response.data;
                                }, ErrorContainer.handleRestError);

                        }
                    })
                }

                $scope.submitForm = function(){
                    $http.post(getStepUrl(), $scope.container.model).then(
                        function(response){
                            console.log(response);
                            NotificationRepository.addNotification({
                                title: "Boek opgeslagen",
                                message: "",
                                type: "success"
                            });
                        }, ErrorContainer.handleRestError);
                };


                function getStepUrl() {
                    var url = $rootScope.baseUrl.concat($scope.currentStep.modelUrl);
                    if ($scope.modelId !== undefined) {
                        url = url.concat("/").concat($scope.modelId);
                    }
                    return url;
                }

                init();
            }]
        };
    });