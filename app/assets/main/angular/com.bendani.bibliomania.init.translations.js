angular.module('BiblioMania')
    .config(['$translateProvider', function ($translateProvider) {
        $translateProvider.translations('nl', {
            'translation.in.collection':'In collectie',
            'translation.no':'Nee',
            'translation.yes':'Ja',
            'translation.reason':'Reden',
            'BORROWED': 'Geleend',
            'SOLD': 'Verkocht',
            'LOST': 'Verloren'
        });

        $translateProvider.translations('en', {
            'translation.in.collection':'In collection',
            'translation.no':'No',
            'translation.yes':'Yes',
            'translation.reason':'Reason',
            'BORROWED': 'Borrowed',
            'SOLD': 'Sold',
            'LOST': 'Lost'
        });

        $translateProvider.preferredLanguage('nl');
        $translateProvider.useSanitizeValueStrategy('sanitize');
    }]);