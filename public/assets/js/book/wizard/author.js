var lastSetAuthorName;
var lastSetAuthorFirstname;
var lastSetAuthorInfix;
var formValidator;

function validateForm() {
    return validate(function(){ return null; })
}

$(function () {
    doAuthorGoogleImageSearch();

    $('#secondary_authors_input').tokenfield({
        autocomplete: window.author_names,
        delimiter: ';',
        createTokensOnBlur: true
    });

    $('#authorImageContent').change(function () {
        if ($(this).is(':checked')) {
            $('#author-image-self-upload-panel').show(250);
            $('#author-image-google-search-panel').hide(250);
        } else {
            $('#author-image-self-upload-panel').hide(250);
            $('#author-image-google-search-panel').show(250);
        }
    });

    $('#author_name').focusout(function () {
        if (lastSetAuthorName !== getAuthorName()) {
            lastSetAuthorName = getAuthorName();
            doAuthorGoogleImageSearch();
        }
    });

    $('#author_firstname').focusout(function () {
        if (lastSetAuthorFirstname !== getAuthorFirstName()) {
            lastSetAuthorFirstname = getAuthorFirstName();
            doAuthorGoogleImageSearch();
        }
    });

    $('#author_infix').focusout(function () {
        if (lastSetAuthorInfix !== getAuthorInfix()) {
            lastSetAuthorInfix = getAuthorInfix();
            doAuthorGoogleImageSearch();
        }
    });
});

function doAuthorGoogleImageSearch() {
    var searchString = getAuthorName() + ' ' + getAuthorInfix() + ' ' + getAuthorFirstName();
    executeGoogleSearch(searchString);
}

function getAuthorFullString() {
    if (getAuthorInfix()) {
        return getAuthorName() + ", " + getAuthorInfix() + ", " + getAuthorFirstName();
    } else {
        return getAuthorName() + ", " + getAuthorFirstName();
    }
}

function setAuthorName(authorName) {
    $("#author_name").val(authorName);
}

function setAuthorFirstName(authorFirstName) {
    $("#author_firstname").val(authorFirstName);
}

function setAuthorInfix(authorInfix) {
    $("#author_infix").val(authorInfix);
}

function getAuthorName() {
    return $("#author_name").val();
}

function getAuthorFirstName() {
    return $("#author_firstname").val();
}

function getAuthorInfix() {
    return $("#author_infix").val();
}


$(document).ready(function () {
    $("img").on('error', function () {
        $(this).hide();
    });

    $('#author_firstname').autocomplete({
        lookup: window.author_firstnames
    });
    $('#author_name').autocomplete({
        lookup: window.author_lastnames
    });
    $('#author_infix').autocomplete({
        lookup: window.author_infix
    });

    // VALIDATORS
    formValidator = $('.createBookForm').bootstrapValidator({
        message: 'This value is not valid',
        message: 'This value is not valid',
        ignore: '',
        framework: 'bootstrap',
        excluded: [':disabled'],
        feedbackIcons: {
            valid: '',
            invalid: '',
            validating: ''
        },
        fields: {
            author_date_of_birth_day: {
                feedbackIcons: false,
                validators: {
                    between: {
                        min: 1,
                        max: 31,
                        message: 'De dag moet tussen 1 en 31 liggen'
                    }
                }
            },
            author_date_of_birth_month: {
                feedbackIcons: false,
                validators: {
                    between: {
                        min: 1,
                        max: 12,
                        message: 'De maand moet tussen 1 en 12 liggen'
                    }
                }
            },
            author_date_of_birth_year: {
                feedbackIcons: false,
                validators: {
                    between: {
                        min: 1000,
                        max: 9999,
                        message: 'Het jaar moet uit 4 cijfers bestaan'
                    }
                }
            },
            author_date_of_death_day: {
                feedbackIcons: false,
                validators: {
                    between: {
                        min: 1,
                        max: 31,
                        message: 'De dag moet tussen 1 en 31 liggen'
                    }
                }
            },
            author_date_of_death_month: {
                feedbackIcons: false,
                validators: {
                    between: {
                        min: 1,
                        max: 12,
                        message: 'De maand moet tussen 1 en 12 liggen'
                    }
                }
            },
            author_date_of_death_year: {
                feedbackIcons: false,
                validators: {
                    between: {
                        min: 1000,
                        max: 9999,
                        message: 'Het jaar moet uit 4 cijfers bestaan'
                    }
                }
            },
            author_bookfromAuthor_publication_year: {
                validators: {
                    between: {
                        min: 1000,
                        max: 9999,
                        message: 'Het jaar moet uit 4 cijfers bestaan'
                    }
                }
            }
        }
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });
});