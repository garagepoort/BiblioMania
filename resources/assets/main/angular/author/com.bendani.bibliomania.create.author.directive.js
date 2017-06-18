(function () {

    'use strict';

    angular.module('com.bendani.bibliomania.create.author.directive',
        [
            'com.bendani.bibliomania.author.model',
            'com.bendani.bibliomania.image.selection.modal.service',
            'com.bendani.bibliomania.name.directive',
            'com.bendani.bibliomania.title.panel'
        ])
        .directive('createAuthor', function () {
            return {
                scope: {
                    onSave: "&",
                    model: '=authorModel',
                    control: '=control',
                    showAuthorExistsWarning: '='
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
        vm.searchAuthors = searchAuthors;

        function init() {
            TitlePanelService.setTitle('translation.author');
            vm.submitAttempted = false;
            vm.authors = Author.query(function () {
            }, ErrorContainer.handleRestError);

            if (!vm.model) {
                vm.model = {};
            }
            vm.showAuthorExistsWarning = !!vm.showAuthorExistsWarning;
            vm.control.submitForm = submitForm;
        }

        function searchAuthors(item) {
            return !!(
            vm.model.name &&
            vm.model.name.lastname && !vm.model.name.lastname.$error &&
            vm.model.name.lastname.length > 2 &&
            item.name.lastname.toLowerCase().indexOf(vm.model.name.lastname.toLowerCase()) !== -1);

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

        function submitForm() {
            vm.submitAttempted = true;
            if (vm.authorForm.$valid) {
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