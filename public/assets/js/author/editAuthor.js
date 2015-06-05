$(function () {

    $('#author-image-self-upload-checkbox').change(function () {
        if ($(this).is(':checked')) {
            $('#author-image-self-upload-panel').show(250);
            $('#author-image-google-search-panel').hide(250);
        } else {
            $('#author-image-self-upload-panel').hide(250);
            $('#author-image-google-search-panel').show(250);
        }
    });

    function doAuthorGoogleImageSearch() {
        var searchString = getAuthorName() + ' ' + getAuthorInfix() + ' ' + getAuthorFirstName();
        executeGoogleSearch(searchString, 'authorImageContent', 'imageUrl');
    }

    function getAuthorName() {
        return $("#nameInput").val();
    }

    function getAuthorFirstName() {
        return $("#firstnameInput").val();
    }

    function getAuthorInfix() {
        return $("#infixInput").val();
    }

    $('#nameInput').focusout(function () {
        doAuthorGoogleImageSearch();
    });

    $('#firstnameInput').focusout(function () {
        doAuthorGoogleImageSearch();
    });

    $('#infixInput').focusout(function () {
        doAuthorGoogleImageSearch();
    });

});