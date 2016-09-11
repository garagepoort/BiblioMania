angular.module('com.bendani.bibliomania.chart.filter.model', [ 'ngResource' ])
    .factory('ChartFilter', ['$resource', function ($resource) {
        return $resource('../BiblioMania/chartFilters', {}, {});
    } ]);