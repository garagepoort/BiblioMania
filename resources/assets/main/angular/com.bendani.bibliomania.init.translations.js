angular.module('BiblioMania')
    .config(['$translateProvider', function ($translateProvider) {
        $translateProvider.translations('nl', {
            'translation.no.books.found': 'Geen boeken gevonden',
            'translation.author': 'Auteur',
            'translation.authors': 'Auteurs',
            'translation.publishers': 'Uitgevers',
            'translation.add.author': 'Auteur toevoegen',
            'translation.author.saved': 'Auteur opgeslagen',
            'translation.existing.authors.found': 'Opgelet! Volgende auteurs bestaan reeds:',
            'translation.in.collection':'In collectie',
            'translation.no':'Nee',
            'translation.yes':'Ja',
            'translation.edit':'Wijzig',
            'translation.reason':'Reden',
            'translation.details':'Detail',
            'translation.not.all.fields.have.been.filled.in':'Niet all velden zijn ingevuld',
            'BORROWED': 'Geleend',
            'SOLD': 'Verkocht',
            'LOST': 'Verloren',

            'user.with.username.exists': 'User met deze username bestaat reeds'
        });

        $translateProvider.translations('en', {
            'translation.no.books.found': 'No books found',
            'translation.author': 'Author',
            'translation.authors': 'Authors',
            'translation.publishers': 'Publishers',
            'translation.add.author': 'Add author',
            'translation.author.saved': 'Author saved',
            'translation.existing.authors.found': 'Warning! Following authors already exist:',
            'translation.in.collection':'In collection',
            'translation.no':'No',
            'translation.yes':'Yes',
            'translation.edit':'Edit',
            'translation.reason':'Reason',
            'translation.details':'Details',
            'translation.not.all.fields.have.been.filled.in': 'Not all fields have been filled in',
            'BORROWED': 'Borrowed',
            'SOLD': 'Sold',
            'LOST': 'Lost',

            'user.with.username.exists': 'User with username already exists'
        });

        $translateProvider.preferredLanguage('nl');
        $translateProvider.useSanitizeValueStrategy('sanitize');
    }]);