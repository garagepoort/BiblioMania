angular
    .module('com.bendani.php.common.wizardservice.wizard.directive', ['ngRoute', 'com.bendani.bibliomania.error.container', "com.bendani.bibliomania.dynamic.controller.directive"])
    .directive('wizard', function () {
        return {
            scope: {
                steps: "=",
                progressStep: "@"
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/wizard/wizard-directive.html",
            controller: ['$rootScope', '$scope', '$controller', '$routeParams', '$http', 'ErrorContainer', function ($rootScope, $scope, $controller, $routeParams, $http, ErrorContainer) {

                function retrieveModel() {
                    $http.get(getStepUrl()).then(
                        function (response) {
                            $scope.container.model = response.data;
                        }, ErrorContainer.handleRestError);
                }

                function init() {
                    $scope.container = {};
                    $scope.container.model = {};
                    $scope.$watch('steps', function (newValue) {
                        if ($scope.steps != undefined) {
                            $scope.currentStep = $scope.steps[$routeParams.step];
                            if ($routeParams.modelId != undefined) {
                                retrieveModel();
                            }
                        }
                    });
                }

                var handleSuccessResponse = function (response) {
                    NotificationRepository.addNotification({
                        title: "Boek opgeslagen",
                        message: "",
                        type: "success"
                    });
                };

                $scope.submitForm = function () {
                    if ($routeParams.modelId === undefined || $routeParams.modelId == '') {
                        $http.post($scope.currentStep.modelUrl, $scope.container.model).then(handleSuccessResponse, ErrorContainer.handleRestError);
                    }else{
                        $scope.container.model.id = $routeParams.modelId;
                        $http.put($scope.currentStep.modelUrl, $scope.container.model).then(handleSuccessResponse, ErrorContainer.handleRestError);
                    }
                };


                function getStepUrl() {
                    var url = $rootScope.baseUrl.concat($scope.currentStep.modelUrl);
                    if ($routeParams.modelId !== undefined) {
                        url = url.concat("/").concat($routeParams.modelId);
                    }
                    return url;
                }

                init();
            }]
        };
    });