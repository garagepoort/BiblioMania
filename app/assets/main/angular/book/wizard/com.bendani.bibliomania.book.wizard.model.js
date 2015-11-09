angular.module('com.bendani.bibliomania.book.wizard.model', ['ngResource'])
    .factory('BookWizard', ['$resource', function ($resource) {
        return $resource('../BiblioMania/bookwizard', {});
    } ]);