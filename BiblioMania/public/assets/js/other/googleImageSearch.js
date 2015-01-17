google.load('search', '1');

var imageSearch;

function searchComplete() {

    // Check that we got results
    if (imageSearch.results && imageSearch.results.length > 0) {

        // Grab our content div, clear it.
        var contentDiv = $('#google-image-search-table');
        contentDiv.empty();

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

            var newImg = $('<img width="150px">');
            newImg.attr('src', result.url);
            newImg.attr('imageUrl', result.url);

            tableData.append(newImg);

            tableRow.append(tableData);

            newImg.on('click', function(){
                $('.google-selected-image').removeClass("google-selected-image");
                $(this).addClass("google-selected-image");
                $('#'+window.imageUrlInput).val($(this).attr('imageUrl'));
            });
        }
        $('#loader-icon').hide();
        $('#google-image-search-table').show();
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

function executeGoogleSearch(searchString){
    $('#google-image-search-table').hide();
    $('#loader-icon').show();
    imageSearch.execute(searchString);
}