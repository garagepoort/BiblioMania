$(document).ready(function(){
    authors_page = 1;

    var waypoint = new Waypoint({
        element: $('#authors-loading-waypoint'),
        handler: function(direction) {
            if(direction === 'down'){
                $('#loader-icon').show();
                $.get(baseUrl + "/getNextAuthors?page=" + authors_page,
                            function(data,status){
                                if(status === "success"){
                                    fillInAuthorContainer(JSON.parse(data));
                                    authors_page = authors_page + 1;
                                }
                                $('#loader-icon').hide();
                            }
                    ).fail(function(){
                        $('#loader-icon').hide();
                        BootstrapDialog.show({
                            message: 'Er ging iets mis. Refresh de pagina even en probeer opnieuw!'
                        });
                    });
            }
        },
        offset: 'bottom-in-view'
    });

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