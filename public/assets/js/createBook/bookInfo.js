var genresOpen =false;

$(function() {

    initializeGenre();

    $('#book_author_input').autocomplete({
        lookup: window.author_names
    });

    $('#book-info-tab-link').click(function(){
        fillAuthorInput();
    });
    $('#searchGoogleInformationButton').click(function(){
        searchBook($('#book_isbn_input').val());
    });

    $('#book_publisher_input').autocomplete({
        lookup: window.publisher_names
    });

   $('.collapsible').collapsible();

    $('#book_author_input').focusout(function () {
        fillInAuthorNamesFromBookInfo();
    });

    $(".genre-listitem").click(function(){
        $(".clickedGenre").removeClass("clickedGenre");
        $(this).addClass("clickedGenre");
        $("#genresGlyphicon").text('    Genre: ' + $(this).attr("name"));
        $("#book_genre_input").val($(this).attr("genreId"));
    });

    $(".genres-header").click(function(){
        if(genresOpen){
            $("#genresGlyphicon").removeClass('glyphicon-chevron-down');
            $("#genresGlyphicon").addClass('glyphicon-chevron-right');
        }else{
            $("#genresGlyphicon").removeClass('glyphicon-chevron-right');
            $("#genresGlyphicon").addClass('glyphicon-chevron-down');
        }
        genresOpen = !genresOpen;
    });

    $("#book_title_input").on("keyup paste", function() {
        var result = $(this).val();
        $("#book-info-title").text(result);
    });

});

function initializeGenre() {
    var genreId = $("#book_genre_input").val();
    if (genreId !== '') {
        var selectedGenre = $(".genre-listitem[genreId=" + genreId + "]");
        if (selectedGenre != null) {
            selectedGenre.addClass("clickedGenre");
            $("#genresGlyphicon").text('    Genre: ' + selectedGenre.attr("name"));
        }
    }
}

function setAuthorNameOnBookInfo(author){
    $('#book_author_input').val(author);
}

