$(document).ready(function(){
    var lastClickedBookId = undefined;
    var bookDetailAnimationBusy = false;

    $('.bookCoverLink').click(function() {
        if(bookDetailAnimationBusy === false){
         	var div = $('.book-detail-div');
            var bookId = $(this).attr('bookId');
            var book = $.grep(books, function(e){ return e.id == bookId; })[0];

         	if(div.hasClass('visible') && lastClickedBookId !== bookId){ 
                
         		closeBookDetail();
                
                div.promise().done(function(){
                    fillInBookInfo(book);
                    openBookDetail(bookId);
                });

                lastClickedBookId = bookId;
                
            }else if (div.hasClass('visible') === false){
                fillInBookInfo(book);
                openBookDetail(bookId);
                lastClickedBookId = bookId;

                div.promise().done(function(){
                    bookDetailAnimationBusy = false;
                });
         	}else{
                closeBookDetail();   
            }
        }
  	});

    $('#book-detail-close-div').click(function(){
        closeBookDetail();
    });

    function closeBookDetail(){
        bookDetailAnimationBusy = true;
        var detail = $('.book-detail-div');
        detail.animate({
            right: "-=600"
        });

        detail.promise().done(function(){
            bookDetailAnimationBusy = false;   
            detail.removeClass('visible');
        });
    }

    function openBookDetail(bookId){
        bookDetailAnimationBusy = true;
        var detail = $('.book-detail-div');
        $.get( "ajax/test.html", function( data ) {
          $( ".result" ).html( data );
        });

        detail.animate({
            right: "+=600"
        });
        detail.promise().done(function(){
            bookDetailAnimationBusy = false;
            detail.addClass('visible');
        });

    }

    function fillInBookInfo(book){
            $('#book-detail-title').text(book.title);
            $('#book-detail-subtitle').text(book.subtitle);
            $('#book-detail-coverimage').attr('src', baseUrl + "/" + book.coverImage);
            $('#book-detail-author').text(book.authors[0].firstname + " " + book.authors[0].infix + " " + book.authors[0].name);
            $('#book-detail-isbn').text(book.ISBN);
            $('#book-detail-publisher').text(book.publisher.name);
            $('#book-detail-genre').text(book.genre.name);
            $('#book-detail-publication-date').text(dateToString(book.publication_date));
            $('#book-detail-number-of-pages').text(book.number_of_pages);
            $('#book-detail-print').text(book.print);
            $('#book-detail-summary').text(book.summary);

            $('#book-detail-summary').shorten({
                moreText: 'meer',
                lessText: 'minder'
            });
            
            $('#book-detail-first-print-title').text(book.first_print_info.title);
            $('#book-detail-first-print-isbn').text(book.first_print_info.ISBN);

            $('#book-detail-retail-price').text(book.retail_price);

            $('#star-detail').raty({
                score : book.personal_book_info.rating,
                number: 10,
                readOnly: true,
                path: baseUrl + "/" + 'assets/raty-2.7.0/lib/images'
            });
    }

    function dateToString(date){
        result = "";
        if(date.day != null){
            result = date.day + "-";
        }
        if(date.month != null){
            result = result + date.month + "-";
        }
        if(date.year != null){
            result = result + date.year;
        }
        return result
    }
    
    $("#filterButton").click(function(){
        if($('#book-collection-filter-panel').is(":visible")){
            $('#book-collection-filter-panel').hide();
        }else{
            $('#book-collection-filter-panel').show();
        }
    });

});