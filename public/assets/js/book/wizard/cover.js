$(document).ready(function () {
    var authorSearchCheckbox = $('#cover-info-author-search-checkbox');
    var titleSearchCheckbox = $('#cover-info-title-search-checkbox');
    var isbnSearchCheckbox = $('#cover-info-isbn-search-checkbox');

    doCoverGoogleImageSearch();

    $('#cover-info-self-upload-checkbox').change(function () {
        if ($(this).is(':checked')) {
            $('#cover-info-self-upload-panel').show(250);
            $('#cover-info-google-search-panel').hide(250);
        } else {
            $('#cover-info-self-upload-panel').hide(250);
            $('#cover-info-google-search-panel').show(250);
        }
    });

    authorSearchCheckbox.on('click', function () {
        doCoverGoogleImageSearch();
    });

    titleSearchCheckbox.on('click', function () {
        doCoverGoogleImageSearch();
    });

    isbnSearchCheckbox.on('click', function () {
        doCoverGoogleImageSearch();
    });

    function doCoverGoogleImageSearch() {
        searchString = '';
        if (authorSearchCheckbox.is(':checked')) {
            searchString = searchString + authorName + " ";
        }
        if (titleSearchCheckbox.is(':checked')) {
            searchString = searchString + bookTitle + " ";
        }
        if (isbnSearchCheckbox.is(':checked')) {
            searchString = searchString + bookIsbn;
        }

        executeGoogleSearch(searchString, 'coverInfoContent', 'coverInfoUrl');
    }
});