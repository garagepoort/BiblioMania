(function () {

    'use strict';

    angular.module('com.bendani.bibliomania.create.author.directive',
        [
            'com.bendani.bibliomania.author.model',
            'com.bendani.bibliomania.image.selection.modal.service',
            'com.bendani.bibliomania.name.directive',
            'com.bendani.bibliomania.title.panel'
        ])
        .directive( 'createAuthor', function () {
            return {
                scope: {
                    onSave: "&",
                    model: '=authorModel'
                },
                restrict: "E",
                templateUrl: "../BiblioMania/views/partials/author/create-author-directive.html",
                controller: ['Author', 'ErrorContainer', 'growl', 'ImageSelectionModalService', 'TitlePanelService', CreateAuthorController],
                controllerAs: 'vm',
                bindToController: true
            };
        });

    function CreateAuthorController(Author, ErrorContainer, growl, ImageSelectionModalService, TitlePanelService) {
        var vm = this;

        vm.searchAuthorImage = searchAuthorImage;
        vm.submitForm = submitForm;
        vm.openSelectImageDialog = openSelectImageDialog;

        function init(){
            TitlePanelService.setTitle('translation.author');
            vm.submitAttempted = false;

            if (!vm.model) {
                vm.model = {};
            }
        }

        function searchAuthorImage() {
            if (vm.model !== undefined && vm.model.name !== undefined) {
                vm.authorImageQuery = vm.model.name.firstname + " " + vm.model.name.lastname;
            }
        }

        function openSelectImageDialog() {
            var searchQuery = '';

            if (vm.model.name) {
                searchQuery = vm.model.name.firstname + ' ' + vm.model.name.lastname;
            }

            ImageSelectionModalService.show(searchQuery, function (image) {
                vm.model.imageUrl = image;
                vm.model.image = image;
            });
        }

        function submitForm(formValid) {
            vm.submitAttempted = true;
            if (formValid) {
                if (vm.model.id) {
                    Author.update(vm.model, function (response) {
                        growl.addSuccessMessage('Auteur opgeslagen');
                        vm.onSave({authorId: response.id});
                    }, ErrorContainer.handleRestError);
                } else {
                    Author.save(vm.model, function (response) {
                        growl.addSuccessMessage('Auteur opgeslagen');
                        vm.onSave({authorId: response.id});
                    }, ErrorContainer.handleRestError);
                }
            } else {
                ErrorContainer.setErrorCode('translation.not.all.fields.have.been.filled.in');
            }
        }

        init();

    }

})();