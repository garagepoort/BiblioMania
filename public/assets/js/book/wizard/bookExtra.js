function validateForm(){
    return true;
}

$(function(){
    $('#translator_input').autocomplete({
        lookup: window.translators
    });
    $('#publisher_serie_input').autocomplete({
        lookup: window.publisher_serie_titles
    });
    $('#book_serie_input').autocomplete({
        lookup: window.serie_titles
    });
});