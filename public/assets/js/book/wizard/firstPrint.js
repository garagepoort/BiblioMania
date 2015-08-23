$(document).ready(function () {
    $('#first_print_country').autocomplete({
        lookup: window.country_names
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
            //FIRST PRINT
            first_print_isbn: {
                validators: {
                    regexp: {
                        regexp: '^[0-9]{13}$',
                        message: 'Exact 13 cijfers'
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