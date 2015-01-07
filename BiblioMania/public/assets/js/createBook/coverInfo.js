google.load('search', '1');

var imageSearch;

function searchComplete() {

    // Check that we got results
    if (imageSearch.results && imageSearch.results.length > 0) {

        // Grab our content div, clear it.
        var contentDiv = $('#cover-image-table');
        contentDiv.empty();

        // Loop through our results, printing them to the page.
        var results = imageSearch.results;


        var tableBody = $('<tbody></tbody>');
        var tableRow = $('<tr></tr>');
        contentDiv.append(tableBody);
        tableBody.append(tableRow);
        for (var i = 0; i < results.length; i++) {
            if(i==4){
                var tableRow = $('<tr></tr>');
                tableBody.append(tableRow);
            }
            // For each result write it's title and image to the screen
            var result = results[i];
            var tableData = $("<td></td>");

            var newImg = $('<img width="150px" height="150px">');
            newImg.attr('src', result.tbUrl);
            newImg.attr('imageUrl', result.url);

            tableData.append(newImg);

            tableRow.append(tableData);

            newImg.on('click', function(){
                $('.cover-info-selected-image').removeClass("cover-info-selected-image");
                $(this).addClass("cover-info-selected-image");
                $('#cover-info-url-input').val($(this).attr('imageUrl'));
            });
        }
    }
}

function OnLoad() {

    // Create an Image Search instance.
    imageSearch = new google.search.ImageSearch();

    // Set searchComplete as the callback function when a search is
    // complete.  The imageSearch object will have results in it.
    imageSearch.setSearchCompleteCallback(this, searchComplete, null);
    imageSearch.setResultSetSize(8);

    // Include the required Google branding
    google.search.Search.getBranding('branding');
}
google.setOnLoadCallback(OnLoad);

$(document).ready(function() {
    $('#cover-tab-link').on('click', function(){
        imageSearch.execute($('#book_title_input').val() + " " + $('#author_name').val() + " " + $('#book_isbn_input').val());
    });

    $('#cover-info-self-upload-checkbox').change(function() {
        if($(this).is(':checked')) {
            $('#cover-info-self-upload-panel').show(250);
            $('#cover-info-google-search-panel').hide(250);
        }else{
            $('#cover-info-self-upload-panel').hide(250);
            $('#cover-info-google-search-panel').show(250);
        }
    });
});