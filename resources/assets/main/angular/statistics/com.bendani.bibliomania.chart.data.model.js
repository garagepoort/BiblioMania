angular.module('com.bendani.bibliomania.chart.data.model', [ 'ngResource' ])
    .factory('ChartData', ['$resource', function ($resource) {
        return $resource('../BiblioMania/chart-data/:id', {}, {
            get: { method : 'GET', url : '../BiblioMania/chart-data/:id', isArray: false}
        });
    } ]);