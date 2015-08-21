$(document).ready(function () {
    $('#first_print_country').autocomplete({
        lookup: window.country_names
    });
});