(function () {
    'use strict';

    angular.module('com.bendani.bibliomania.create.user.ui', ['com.bendani.bibliomania.user.model'])
        .config(['$routeProvider', createUserConfig])
        .controller('CreateUserController', ['User', 'ErrorContainer', 'growl', '$location', 'TitlePanelService', CreateUserController]);

    function createUserConfig($routeProvider) {
        $routeProvider
            .when('/create-user', {
                templateUrl: '../BiblioMania/views/partials/create-user.html',
                controller: 'CreateUserController',
                controllerAs: 'vm'
            });
    }

    function CreateUserController(User, ErrorContainer, growl, $location, TitlePanelService) {
        var vm = this;

        vm.submitForm = submitForm;

        function init(){
            vm.model = {};
            TitlePanelService.setTitle('Create user');
        }

        function submitForm(formValid){
            vm.submitAttempted = true;
            if (formValid) {
                User.save(vm.model, function (response) {
                    growl.addSuccessMessage('User aangemaakt, verificatie mail verstuurd');
                    $location.path('/login');
                }, ErrorContainer.handleRestError);
            }
        }

        init();
    }
})();