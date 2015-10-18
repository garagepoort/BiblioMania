var genresOpen = false;
function validateForm() {
    formSubmitting = true;
    var errorMessage = validateGenre();
    if (errorMessage) {
        showError("error-div", errorMessage);
        return false;
    }
    hideError("error-div");
    return true;
}

function validateGenre() {
    var errorMessage = null;
    if ($('#book_genre_input').val() == "") {
        errorMessage = "Genre moet ingevuld zijn";
    }
    return errorMessage;
}

$(function () {

    initializeGenre();

    $('#searchGoogleInformationButton').click(function () {
        searchBook($('#book_isbn_input').val());
    });

    $('#book_publisher_input').autocomplete({
        lookup: window.publisher_names
    });

    $('#tag_input').tokenfield({
        autocomplete: window.tags,
        delimiter: ';',
        createTokensOnBlur: true
    })

    $('.collapsible').collapsible();

    $(".genre-listitem").click(function () {
        $(".active").removeClass("active");

        $(this).addClass("active");

        $("#genresGlyphicon").text('    Genre: ' + $(this).attr("name"));
        $("#book_genre_input").val($(this).attr("genreId"));
    });

    $(".genres-header").click(function () {
        if (genresOpen) {
            $('.collapsible').collapsible('closeAll');
            $("#genresGlyphicon").removeClass('glyphicon-chevron-down');
            $("#genresGlyphicon").addClass('glyphicon-chevron-right');
        } else {
            $("#genresGlyphicon").removeClass('glyphicon-chevron-right');
            $("#genresGlyphicon").addClass('glyphicon-chevron-down');
        }
        genresOpen = !genresOpen;
    });

    $("#book_title_input").on("keyup paste", function () {
        var result = $(this).val();
        $("#book-info-title").text(result);
    });

});

function initializeGenre() {
    var genreId = $("#book_genre_input").val();
    if (genreId !== '') {
        var selectedGenre = $(".genre-listitem[genreId=" + genreId + "]");
        if (selectedGenre != null) {
            selectedGenre.addClass("active");
            $("#genresGlyphicon").text('    Genre: ' + selectedGenre.attr("name"));
        }
    }
}


$(document).ready(function () {
    $('#book_country').autocomplete({
        lookup: window.country_names
    });

    $("img").on('error', function () {
        $(this).hide();
    });

    // VALIDATORS
    $('#createOrEditBookForm').bootstrapValidator({
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
            //BOOK
            book_title: {
                message: 'The title is not valid',
                validators: {
                    notEmpty: {
                        message: 'De titel moet ingevuld zijn.'
                    }
                }
            },
            book_author: {
                message: 'De auteur is niet ok',
                validators: {
                    notEmpty: {
                        message: 'De auteur moet ingevuld zijn.'
                    }
                }
            },
            book_isbn: {
                validators: {
                    regexp: {
                        regexp: '^[0-9]{13}$',
                        message: 'Exact 13 cijfers'
                    },
                    notEmpty: {
                        message: 'Het ISBN moet ingevuld zijn.'
                    }
                }
            },
            book_publisher: {
                message: 'De uitgever is niet ingevuld',
                validators: {
                    notEmpty: {
                        message: 'Het uitgever moet ingevuld zijn.'
                    }
                }
            },
            book_publication_date_day: {
                feedbackIcons: 'false',
                validators: {
                    between: {
                        min: 1,
                        max: 31,
                        message: 'De dag moet tussen 1 en 31 liggen'
                    }
                }
            },
            book_publication_date_month: {
                feedbackIcons: false,
                validators: {
                    between: {
                        min: 1,
                        max: 12,
                        message: 'De maand moet tussen 1 en 12 liggen'
                    }
                }
            },
            book_publication_date_year: {
                feedbackIcons: false,
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