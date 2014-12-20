var genresOpen =false;

$(function() {

    $('#book_author').autocomplete({
        lookup: window.author_names
    });

    $("#book_author_input").on("keyup paste", function() {
        var trimmedValue = $(this).val().replace(" ","");
        var result = trimmedValue.split(",");
        $("#author_name").val(result[0]);
        $("#author_firstname").val(result[1]);
    });


   $('.collapsible').collapsible();

    $(".genre-listitem").hover(function(){
        if (!$(this).hasClass("clickedGenre")) {
            $(this).css("background-color","#DDDCC5");
            $(this).css("color","#611427");
        }
    },function(){
        if (!$(this).hasClass("clickedGenre")) {
            $(this).css("background-color","#611427");
            $(this).css("color","#DDDCC5");
        }
    });

    $(".genre-listitem").click(function(){
        $(".clickedGenre").css("background-color","#611427");
        $(".clickedGenre").css("color","#DDDCC5");
        $(".clickedGenre").removeClass("clickedGenre");
        $(this).addClass("clickedGenre");
        $(".genres-header").text('Genres: selected ' + $(this).attr("name"));
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

