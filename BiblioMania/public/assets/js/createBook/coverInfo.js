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