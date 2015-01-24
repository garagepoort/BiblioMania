$(document).ready(function(){

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
                trString = trString + '<td>';
                trString = trString + "<a href='" + baseUrl + "/getAuthor/" + author.id +  "'><img src=\"" + imageString + "\" authorid='" + author.id + "' class='authorCoverLink'></a>";
                trString = trString + "<p>" + author.firstname + " " + author.name +"</p>";
                trString = trString + '</td>';
            }
            trString = trString + '</tr>';
            $('#authors-container-table > tbody:last').append(trString);
        }
        Waypoint.refreshAll();
    }
});