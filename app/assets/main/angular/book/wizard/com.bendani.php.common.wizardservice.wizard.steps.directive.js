angular
    .module('com.bendani.php.common.wizardservice.wizard.steps.directive', [])
    .directive('wizardSteps', function (){
        return {
            scope: {
                steps: "=",
                progressStep: "@",
                currentStep: "="
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/wizard/wizard-steps-directive.html",
            controller: ['$scope', function($scope) {
                $scope.getWizardClass = function(step){
                    if(step.number == $scope.currentStep.number){
                        return 'current';
                    }
                    if($scope.progressStep == 'COMPLETE' || step.number < $scope.progressStep){
                        return 'before';
                    }
                    if(step.number == $scope.progressStep){
                        return 'progress';
                    }
                    return '';
                }
            }]
        };
    });