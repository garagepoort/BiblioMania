(function () {

    'use strict';

    angular.module('com.bendani.bibliomania.series.overview.ui', [
            'com.bendani.bibliomania.serie.model',
            'com.bendani.bibliomania.publisher.serie.model',
            'com.bendani.bibliomania.book.model',
            'com.bendani.bibliomania.book.overview.service',
            'com.bendani.bibliomania.edit.serie.modal.service',
            'com.bendani.bibliomania.confirmation.modal.service',
            'com.bendani.bibliomania.title.panel'])
        .config(['$routeProvider', function ($routeProvider) {
            $routeProvider.when('/series', {
                templateUrl: '../BiblioMania/views/partials/book/series-overview.html',
                controller: 'SeriesOverviewController',
                controllerAs: 'vm',
                resolve: {
                    title: function () {
                        return 'Boeken reeksen';
                    },
                    client: ['Serie', function (Serie) {
                        return Serie;
                    }],
                    type: function () {
                        return 'BOOK';
                    }
                }
            });
            $routeProvider.when('/publisherseries', {
                templateUrl: '../BiblioMania/views/partials/book/series-overview.html',
                controller: 'SeriesOverviewController',
                controllerAs: 'vm',
                resolve: {
                    title: function () {
                        return 'Uitgever reeksen';
                    },
                    client: ['PublisherSerie', function (PublisherSerie) {
                        return PublisherSerie;
                    }],
                    type: function () {
                        return 'PUBLISHER';
                    }
                }
            });
        }])
        .controller('SeriesOverviewController', ['ErrorContainer',
            'TitlePanelService', 'BookOverviewService', '$location',
            'EditSerieModalService', 'ConfirmationModalService', 'title', 'client',
            'type', SeriesOverviewController]);

    function SeriesOverviewController(ErrorContainer,
                                      TitlePanelService, BookOverviewService,
                                      $location, EditSerieModalService, ConfirmationModalService,
                                      title, client, type) {

        var vm = this;

        vm.search = search;
        vm.onImageClickBook = onImageClickBook;
        vm.editSerie = editSerie;
        vm.onEditBook = onEditBook;
        vm.deleteSerie = deleteSerie;

        function init() {
            TitlePanelService.setTitle(title);
            TitlePanelService.setShowPreviousButton(false);

            vm.searchSeriesQuery = "";
            vm.predicate = "name";
            vm.reverseOrder = false;

            vm.orderValues = [
                {key: 'Naam', predicate: 'name', width: '50'}
            ];

            loadSeries();
        }

        function search(item) {
            return (item.name.toLowerCase().indexOf(vm.searchSeriesQuery) !== -1);
        }

        function onImageClickBook(book) {
            BookOverviewService.selectBook(book);
        }

        function editSerie(serie) {
            var filters = type === 'PUBLISHER' ? [{id: "book-publisher", value: [{value: serie.publisherId}]}] : [];
            EditSerieModalService.show(serie, filters, client, function () {});
        }

        function deleteSerie(serie){
            ConfirmationModalService.show('Bent u zeker dat u deze serie wilt verwijderen?', function(){
                client.delete({id: serie.id}, function(){
                    var index = vm.series.indexOf(serie);
                    if(index > -1){
                        vm.series.splice(index, 1);
                    }
                }, ErrorContainer.handleRestError);
            });
        }

        function onEditBook(book) {
            $location.path('/book-details/' + book.id);
        }

        function loadSeries() {
            vm.loading = true;
            vm.series = client.query(function () {
                vm.loading = false;
            }, ErrorContainer.handleRestError);
        }

        init();
    }
}());