angular.module('com.bendani.bibliomania.book.filter.parent', [])
.directive('filterParent', [ '$compile', function($compile){
    return {
        scope: {
            filter: "="
        },
        template: '<div></div>',
        restrict: 'E',
        link: function($scope, $elem){
            var htm = "";
            if($scope.filter.type === "boolean"){
                htm = '<book-filter-boolean filter="filter"></book-filter-boolean>';
            }
            if($scope.filter.type === "text"){
                htm = '<book-filter-text filter="filter"></book-filter-text>';
            }
            var compiled = $compile(htm)($scope);
            $elem.append(compiled);
        }
    }
}])