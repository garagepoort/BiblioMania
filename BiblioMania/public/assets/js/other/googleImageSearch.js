google.load('search', '1');
google.setOnLoadCallback(OnLoad);

var imageSearch;
var contentDivId;
var googleImageSearchTable;
var loader;
var imageUrlInput;

function searchComplete() {

    // Check that we got results
    if (imageSearch.results && imageSearch.results.length > 0) {


        googleImageSearchTable.empty();

        var results = imageSearch.results;


        var tableBody = $('<tbody></tbody>');
        var tableRow = $('<tr></tr>');
        googleImageSearchTable.append(tableBody);
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
            newImg.attr('src', result.tbUrl);
            newImg.attr('imageUrl', result.url);
            if(result.url === $('#'+imageUrlInput).val()){
                newImg.addClass("google-selected-image");
                newImg.addClass(contentDivId);
            }

            tableData.append(newImg);

            tableRow.append(tableData);

            newImg.on('click', function(){
                $('.' + contentDivId).removeClass("google-selected-image");
                $('.' + contentDivId).removeClass(contentDivId);
                $(this).addClass("google-selected-image");
                $(this).addClass(contentDivId);
                $('#'+imageUrlInput).val($(this).attr('imageUrl'));
            });
        }
        loader.hide();
        googleImageSearchTable.show();
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

function executeGoogleSearch(searchString, contentDiv, imageUrl){
    contentDivId = contentDiv;
    imageUrlInput = imageUrl;

    loader =  $('#'+ contentDivId + ' > :nth-child(1)');
    googleImageSearchTable = $('#'+ contentDivId + ' > :nth-child(2)');

    googleImageSearchTable.hide();
    loader.show();

    imageSearch.execute(searchString);
}