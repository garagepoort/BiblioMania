$(function() {

    $('#book_author').autocomplete({
        lookup: window.author_names
    });

   $('.collapsible').collapsible();

    $(".genre-listitem").hover(function(){
        if (!$(this).hasClass("clickedGenre")) {
            $(this).css("background-color","#611427");
            $(this).css("color","#DDDCC5");
        }
    },function(){
        if (!$(this).hasClass("clickedGenre")) {
            $(this).css("background-color","#DDDCC5");
            $(this).css("color","#611427");
        }
    });

    $(".genre-listitem").click(function(){
        $(".clickedGenre").css("background-color","#DDDCC5");
        $(".clickedGenre").css("color","#611427");
        $(".clickedGenre").removeClass("clickedGenre");
        $(this).addClass("clickedGenre");
        $(".genres-header").text('Genres: selected ' + $(this).attr("name"));
        $("#book_genre_input").val($(this).attr("genreId"));
    });
});

