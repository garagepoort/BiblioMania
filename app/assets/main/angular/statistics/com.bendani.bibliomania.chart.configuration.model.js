angular.module('com.bendani.bibliomania.chart.configuration.model', [ 'ngResource' ])
    .factory('ChartConfiguration', ['$resource', function ($resource) {
        return $resource('../BiblioMania/chart-configurations/:id', {}, {
            update: { method : 'PUT', url : '../BiblioMania/chart-configurations'},
            xproperties: { method : 'GET', url : '../BiblioMania/chart-configurations/xproperties', isArray: true}
        });
    } ]);