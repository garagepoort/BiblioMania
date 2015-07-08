var formSubmitting = false;

function showError(errorMessage){
    $('#error-message').html(errorMessage);
    $('#error-div').show();
    window.scrollTo(0, 0);
}

function hideError(){
    $('#error-div').hide();
}

function validateForm(){
    formSubmitting = true;
    var errorMessage = validateOeuvreList();
    if(errorMessage){
        showError(errorMessage);
        return false;
    }
    errorMessage = validateGenre();
    if(errorMessage){
        showError(errorMessage);
        return false;
    }
    hideError();
    return true;
}

$(document).ready(function () {
    window.addEventListener("beforeunload", function (e) {
        var confirmationMessage = 'It looks like you have been editing something. ';
        confirmationMessage += 'If you leave before saving, your changes will be lost.';

        if (formSubmitting) {
            return undefined;
        }

        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
        return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
    });

    $('#book_country').autocomplete({
        lookup: window.country_names
    });
    $('#first_print_country').autocomplete({
        lookup: window.country_names
    });

    $('#buy_info_country').autocomplete({
        lookup: window.country_names
    });

    $("img").on('error', function () {
        $(this).hide();
    });

    // VALIDATORS
    $('.createBookForm').bootstrapValidator({
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
            book_print: {
                message: 'De uitgever is niet ingevuld',
                validators: {
                    regexp: {
                        regexp: '^[0-9]*$',
                        message: 'Kan enkel cijfers zijn'
                    }
                }
            },
            book_number_of_pages: {
                message: 'De uitgever is niet ingevuld',
                validators: {
                    regexp: {
                        regexp: '^[0-9]*$',
                        message: 'Kan enkel cijfers zijn'
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
            },
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
            },
            //FIRST PRINT
            first_print_isbn: {
                validators: {
                    regexp: {
                        regexp: '^[0-9]{13}$',
                        message: 'Exact 13 cijfers'
                    }
                }
            },
            //BUY PRINT
            buy_info_price_payed: {
                validators: {
                    numeric: {
                        separator: ','
                    }
                }
            },
            buy_book_info_retail_price: {
                validators: {
                    numeric: {
                        separator: ','
                    }
                }
            },
            gift_book_info_retail_price: {
                validators: {
                    numeric: {
                        separator: ','
                    }
                }
            }
        }
    }).on('err.field.bv', function (e, data) {
        if (data.bv.getSubmitButton()) {
            data.bv.disableSubmitButtons(false);
        }
    }).on('success.field.bv', function (e, data) {
        if (data.bv.getSubmitButton()) {
            data.bv.disableSubmitButtons(false);
        }
    });
});