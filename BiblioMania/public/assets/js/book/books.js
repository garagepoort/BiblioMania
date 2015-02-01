$(document).ready(function(){
    var lastClickedBookId = undefined;
    var bookDetailAnimationBusy = false;
    nextBooksUrl = "/getNextBooks?";

    if(window.book_id != null){
        startLoadingPaged(window.baseUrl + nextBooksUrl + "book_id=" + window.book_id, 1, fillInBookContainer);
    }else{
        startLoadingPaged(window.baseUrl + nextBooksUrl, 1, fillInBookContainer);
    }

    $('#orderby-select-box').change(function(){
        $('#books-container-table > tbody').empty();
        abortLoadingPaged();
        startLoadingPaged(window.baseUrl + "/getNextBooks?" + 'order_by=' + $('#orderby-select-box').val(), 1, fillInBookContainer);
    });

    function doSearchBooks(){
        window.book_id = null;
        var url = window.baseUrl + "/getNextBooks?bookTitle=" + $('#searchBooksInput').val();
        $('#books-container-table > tbody').empty();
        abortLoadingPaged();
        startLoadingPaged(url, 1, fillInBookContainer);
    }

    function doFilterBooks(){
        var url = window.baseUrl + "/getNextBooks?";
        var params = {
            bookTitle:$('#title-filter-input').val(),
            book_subtitle:$('#subtitle-filter-input').val(),
            book_author_name:$('#author-name-filter-input').val(),
            book_author_firstname:$('#author-firstname-filter-input').val()
        };
        url = url + jQuery.param( params );

        $('#books-container-table > tbody').empty();
        abortLoadingPaged();
        startLoadingPaged(url, 1, fillInBookContainer);
    }

    $("#searchBooksInput").keyup(function (e) {
        if (e.keyCode == 13) {
            doSearchBooks();
        }
    });

    $('#searchBooksButton').on('click', function(){
        doSearchBooks();
    });

    $('#book-filters-button').on('click', function(){
        doFilterBooks();
    });

    function fillInBookContainer(data){
        var books = data.data;
        var amountBooks = Object.keys(books).length;

        for (var i = 0; i < amountBooks/6; i++ ) {
            var columns = 6;
            if(i*6+6 > amountBooks){
                columns =  amountBooks % 6;
            }

            var trString = "<tr>";

            for (j = 0; j < columns; j++){
                var book = books[(6*i)+j];
                var imageString = baseUrl + "/" + book.coverImage;
                trString = trString + '<td>';
                trString = trString + "<div class='imageLinkWrapper'>";
                trString = trString + "<img src=\"" + imageString + "\" bookid='" + book.id + "' class='bookCoverLink'>";
                trString = trString + '</div>';
                trString = trString + '</td>';
            }
            trString = trString + '</tr>';
            $('#books-container-table > tbody:last').append(trString);
        }

        $('.bookCoverLink').dblclick(function(){
            var bookId = $(this).attr('bookId');
            window.location = baseUrl + "/editBook/" + bookId;
        });

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

        Waypoint.refreshAll();
    }

    $('#book-detail-close-div').click(function(){
        closeBookDetail();
    });

    function closeBookDetail(){
        bookDetailAnimationBusy = true;
        var detail = $('.book-detail-div');
        detail.animate({
            right: "-=700"
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
            right: "+=700"
        });
        detail.promise().done(function(){
            bookDetailAnimationBusy = false;
            detail.addClass('visible');
        });

    }

    function fillInBookInfo(book){
            if(book.personal_book_info.owned == 1){
                $('#book-detail-owned').prop('checked', true);
            }else{
                $('#book-detail-owned').prop('checked', false);
            } 
            if(book.personal_book_info.read == 1){
                $('#book-detail-read').prop('checked', true);
            }else{
                $('#book-detail-read').prop('checked', false);
            }

            $('#book-detail-title').text(book.title);
            $('#book-detail-subtitle').text(book.subtitle);
            $('#book-detail-coverimage').attr('src', baseUrl + "/" + book.coverImage);
            $('#book-detail-author').text(book.authors[0].firstname + " " + book.authors[0].infix + " " + book.authors[0].name);
            showOrHide($('#book-detail-isbn'), book.ISBN);
            showOrHide($('#book-detail-publisher'), book.publisher.name);
            showOrHide($('#book-detail-country'), book.country.name);
            showOrHide($('#book-detail-genre'), book.genre.name);
            showOrHide($('#book-detail-publication-date'), dateToString(book.publication_date));
            $('#book-detail-summary').text(book.summary);
            if(book.serie != null){
                showOrHide($('#book-detail-serie'), book.serie.name);
            }else{
                $('#book-detail-serie').parent().parent().hide();
            }
            if(book.publisher_serie != null){
                showOrHide($('#book-detail-publisher-serie'), book.publisher_serie.name);
            }else{
                $('#book-detail-publisher-serie').parent().parent().hide();
            }

            $('#book-detail-summary').shorten({
                moreText: 'meer',
                lessText: 'minder',
                showChars: '200'
            });

            // FIRST PRINT

            if(book.first_print_info != null) {
                $('book-detail-small-info-panel').show();
                showOrHide($('#book-detail-first-print-title'), book.first_print_info.title);
                showOrHide($('#book-detail-first-print-subtitle'), book.first_print_info.subtitle);
                showOrHide($('#book-detail-first-print-isbn'), book.first_print_info.ISBN);
                showOrHide($('#book-detail-first-print-publication-date'), dateToString(book.first_print_info.publication_date));
                if(book.first_print_info.country != null){
                    showOrHide($('#book-detail-first-print-country'), book.first_print_info.country.name);
                }else{
                    showOrHide($('#book-detail-first-print-country'), '');
                }
                if(book.first_print_info.language != null) {
                    showOrHide($('#book-detail-first-print-language'), book.first_print_info.language.language);
                }else{
                    showOrHide($('#book-detail-first-print-language'), '');
                }
                if(book.first_print_info.publisher != null) {
                    showOrHide($('#book-detail-first-print-publisher'), book.first_print_info.publisher.name);
                }else{
                    showOrHide($('#book-detail-first-print-publisher'), '');
                }
            }else{
                $('book-detail-small-info-panel').hide();
            }
            // EXTRA INFO
            showOrHide($('#book-detail-retail-price'), "€ " + book.retail_price);
            showOrHide($('#book-detail-number-of-pages'), book.number_of_pages);
            showOrHide($('#book-detail-print'), book.print);

            //BUY OR GIFT
            if(book.personal_book_info.buy_info == null){
                $('.buy-info-tr').hide();
                $('.gift-info-tr').show();
                showOrHide($('#book-detail-gift-info-from'), book.personal_book_info.gift_info.from);
                showOrHide($('#book-detail-gift-info-occasion'), book.personal_book_info.gift_info.occasion);
                showOrHide($('#book-detail-gift-info-date'), book.personal_book_info.gift_info.receipt_date);
            }else{
                $('.buy-info-tr').show();
                $('.gift-info-tr').hide();
                showOrHide($('#book-detail-buy-info-date'), book.personal_book_info.buy_info.buy_date);
                showOrHide($('#book-detail-buy-info-price-payed'), book.personal_book_info.buy_info.price_payed);
                showOrHide($('#book-detail-buy-info-shop'), book.personal_book_info.buy_info.shop);
                showOrHide($('#book-detail-buy-info-city'), book.personal_book_info.buy_info.city);
                showOrHide($('#book-detail-buy-info-recommended-by'), book.personal_book_info.buy_info.recommended_by);
            }

            $('#star-detail').raty({
                score : book.personal_book_info.rating,
                number: 10,
                readOnly: true,
                path: baseUrl + "/" + 'assets/raty-2.7.0/lib/images'
            });
    }

    function showOrHide(element, value){
        if(value === "" || value == 0 || value == null){
            element.parent().parent().hide();
        }else{
            element.text(value);
            element.parent().parent().show();
        }
    }

    function dateToString(date){
        if(date != null){
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
        return "";
    }
    
    $("#filterButton").click(function(){
        if($('#book-collection-filter-panel').is(":visible")){
            $('#book-collection-filter-panel').hide();
        }else{
            $('#book-collection-filter-panel').show();
        }
    });

});