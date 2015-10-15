function searchBook(isbn){
    $.isLoading({
        text: "Loading",
        'class': "icon-refresh",
        'tpl': '<span class="isloading-wrapper %wrapper%">%text%<i class="%class% fa fa-refresh fa-spin"></i></span>'
    });
    $.get('https://www.googleapis.com/books/v1/volumes?q=isbn:' + isbn,
        function (data, status) {
            if (status === "success") {
                if(data.items != undefined){
                    volumeInfo = data.items[0].volumeInfo;
                    $('#book_title_input').val(volumeInfo.title);

                    //if(volumeInfo.authors != undefined){
                    //    authorFirstName = volumeInfo.authors[0].split(" ")[0];
                    //    authorLastName = volumeInfo.authors[0].split(" ")[1];
                    //    $('#book_author_input').val(authorLastName + ", " +authorFirstName);
                    //}

                    if(volumeInfo.publisher){
                        $('#book_publisher_input').val(volumeInfo.publisher)
                    }

                    if(volumeInfo.publishedDate){
                        $('#book_publication_date_year').val(volumeInfo.publishedDate.substring(0,4))
                    }

                    //if(volumeInfo.pageCount){
                    //    $('#book_number_of_pages_input').val(volumeInfo.pageCount)
                    //}
                    //
                    //if(volumeInfo.description){
                    //    $('#book_summary_input').val(volumeInfo.description)
                    //}
                }
            }
            $.isLoading("hide");
        }
    );
}