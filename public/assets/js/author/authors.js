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

            var trElement = $("<tr></tr>");
            for (j = 0; j < columns; j++){
                var author = authors[(6*i)+j];
                var imageString = baseUrl + "/authorImages/sprite.png";
                if(author.useSpriteImage == false){
                    imageString = baseUrl + "/authorImages/" + author.image;
                }
                var height = author.imageHeight;

                var styleString =  "width: " +author.imageWidth+ "px;height:" + author.imageHeight +"px; background: url(" + imageString+");";
                styleString =  styleString + "background-position:  0px -"+ author.spritePointer +"px; display: block;";
                if (author.image == '' || author.image == null) {
                    imageString = baseUrl + "/images/questionCover.png";
                    styleString = "width: 142px; height: 210px; display: block; background: url(" + imageString + ");";
                    var height = 210;
                }
                var tdElement = $("<td></td>");

                var materialCard = $("<div></div>");
                materialCard.attr("class", "imageLinkWrapper material-card");

                var materialContent = $("<div></div>");
                materialContent.attr("class", "material-card-content");

                var materialTitle = $("<div>" + author.firstname + " " + author.name+ "</div>");
                materialTitle.attr("class", "material-card-title");

                var linkElement = $("<a></a>");
                linkElement.attr("href", baseUrl + "/getAuthor/" + author.id);
                linkElement.attr("style", styleString);

                materialContent.append(linkElement);
                materialCard.append(materialContent);
                materialCard.append(materialTitle);
                tdElement.append(materialCard);
                trElement.append(tdElement);
            }
            $('#authors-container-table > tbody:last').append(trElement);
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