$(document).ready(function(){
    var lastClickedBookId = undefined;
    var bookDetailAnimationBusy = false;

    $('.bookCoverLink').click(function() {
        if(bookDetailAnimationBusy === false){
         	var div = $('.book-detail-div');
            var bookId = $(this).attr('bookId');
            var book = $.grep(books, function(e){ return e.id == bookId; });

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
            $('#book-detail-title').text(book[0].title);
            $('#book-detail-subtitle').text(book[0].subtitle);
            $('#book-detail-coverimage').attr('src', book[0].coverImage);
            $('#book-detail-author').text(book[0].author);
            $('#book-detail-isbn').text(book[0].ISBN);
    }
});