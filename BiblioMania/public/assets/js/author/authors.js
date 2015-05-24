$(document).ready(function(){
    $("#searchAuthorsInput").keyup(function (e) {
        if (e.keyCode == 13) {
            searchAuthors();
        }
    });

    $('#searchAuthorsButton').on('click', function () {
        searchAuthors();
    });

    startLoadingPaged(baseUrl + "/getNextAuthors?orderBy=name", 1, fillInAuthorContainer);

    function fillInAuthorContainer(data){
        var authors = data.data;

        for (var i = 0; i < authors.length/6; i++ ) {
            var columns = 6;
            if(i*6+6 > authors.length){
                columns =  authors.length % 6;
            }

            var trString = "<tr>";

            for (j = 0; j < columns; j++){
                var author = authors[(6*i)+j];
                var imageString = baseUrl + "/" + author.image;
                trString = trString + "<td>";
                trString = trString + "<div class='imageLinkWrapper'>";
                trString = trString + "<a href='" + baseUrl + "/getAuthor/" + author.id +  "'><img src=\"" + imageString + "\" authorid='" + author.id + "' class='authorCoverLink'></a>";
                trString = trString + "<p>" + author.firstname + " " + author.name +"</p>";
                trString = trString + '</div>';
                trString = trString + '</td>';
            }
            trString = trString + '</tr>';
            $('#authors-container-table > tbody:last').append(trString);
        }
    }

    function searchAuthors(){
        window.book_id = null;
        var query = $('#searchAuthorsInput').val();
        var operator = $('#search_param_operator').val();
        var type = $('#search_param_type').val();
        var url = window.baseUrl + "/getNextAuthors?query=" + query
            + "&operator=" + operator
            + "&type=" + type
            + "&orderBy=name";
        $('#authors-container-table > tbody').empty();
        abortLoadingPaged();
        startLoadingPaged(url, 1, fillInAuthorContainer);
    }
});