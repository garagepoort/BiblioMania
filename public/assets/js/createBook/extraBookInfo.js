$(function() {

    $('#book_serie_input').autocomplete({
        lookup: window.serie_titles
    });

    $('#publisher_serie_input').autocomplete({
        lookup: window.publisher_serie_titles
    });
});

