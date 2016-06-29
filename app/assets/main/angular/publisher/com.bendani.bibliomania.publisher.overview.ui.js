(function () {
    'use strict';

    angular.module('com.bendani.bibliomania.publisher.overview.ui', [
            'com.bendani.bibliomania.publisher.model',
            'com.bendani.bibliomania.title.panel',
            'com.bendani.bibliomania.confirmation.modal.service'])
        .config(['$routeProvider', function ($routeProvider) {
            $routeProvider.when('/publishers', {
                templateUrl: '../BiblioMania/views/partials/publisher/publishers-overview.html',
                controller: 'PublishersOverviewController',
                controllerAs: 'vm'
            });
        }])
        .controller('PublishersOverviewController', ['Publisher', 'ErrorContainer', 'TitlePanelService', 'ConfirmationModalService', PublishersOverviewController]);

    function PublishersOverviewController(Publisher, ErrorContainer, TitlePanelService, ConfirmationModalService) {

        var vm = this;

        vm.search = search;
        vm.setListView = setListView;
        vm.deletePublisher = deletePublisher;

        function init() {
            TitlePanelService.setTitle('translation.publishers');
            TitlePanelService.setShowPreviousButton(false);

            vm.searchSeriesQuery = "";
            vm.predicate = "name";
            vm.reverseOrder = false;

            vm.orderValues = [
                {key: 'Naam', predicate: 'name', width: '50'}
            ];

            loadPublishers();

        }

        function search(item) {
            if (!vm.searchPublisherQuery) {
                return true;
            }
            return (item.name.toLowerCase().indexOf(vm.searchPublisherQuery.toLowerCase()) !== -1);

        }

        function setListView(value) {
            vm.listView = value;
        }

        function deletePublisher(publisher){
            ConfirmationModalService.show('Bent u zeker dat u deze uitgever wilt verwijderen?', function() {
                Publisher.delete({id: publisher.id}, function () {
                    var index = vm.publishers.indexOf(publisher);
                    if (index > -1) {
                        vm.publishers.splice(index, 1);
                    }
                }, ErrorContainer.handleRestError);
            });
        }

        function loadPublishers() {
            vm.loading = true;
            vm.publishers = Publisher.query(function () {
                vm.loading = false;
            }, ErrorContainer.handleRestError);
        }

        init();
    }
}());