angular.module('com.bendani.bibliomania.chart.configuration.model', [ 'ngResource' ])
    .factory('ChartConfiguration', ['$resource', function ($resource) {
        return $resource('../BiblioMania/chart-configurations/:id', {}, {
            get: { method : 'GET', url : '../BiblioMania/chart-configurations', isArray: true}
        });
    } ]);