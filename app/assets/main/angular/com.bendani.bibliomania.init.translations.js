angular.module('BiblioMania')
    .config(['$translateProvider', function ($translateProvider) {
        $translateProvider.translations('nl', {
            'translation.author': 'Auteur',
            'translation.authors': 'Auteurs',
            'translation.add.author': 'Auteur toevoegen',
            'translation.author.saved': 'Auteur opgeslagen',
            'translation.existing.authors.found': 'Opgelet! Volgende auteurs bestaan reeds:',
            'translation.in.collection':'In collectie',
            'translation.no':'Nee',
            'translation.yes':'Ja',
            'translation.reason':'Reden',
            'translation.not.all.fields.have.been.filled.in':'Niet all velden zijn ingevuld',
            'BORROWED': 'Geleend',
            'SOLD': 'Verkocht',
            'LOST': 'Verloren'
        });

        $translateProvider.translations('en', {
            'translation.author': 'Author',
            'translation.authors': 'Authors',
            'translation.add.author': 'Add author',
            'translation.author.saved': 'Author saved',
            'translation.existing.authors.found': 'Warning! Following authors already exist:',
            'translation.in.collection':'In collection',
            'translation.no':'No',
            'translation.yes':'Yes',
            'translation.reason':'Reason',
            'translation.not.all.fields.have.been.filled.in': 'Not all fields have been filled in',
            'BORROWED': 'Borrowed',
            'SOLD': 'Sold',
            'LOST': 'Lost'
        });

        $translateProvider.preferredLanguage('nl');
        $translateProvider.useSanitizeValueStrategy('sanitize');
    }]);