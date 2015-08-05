var lastClickedBookId = undefined;
var bookDetailAnimationBusy = false;
var currencies = new Object();

$(document).ready(function () {
    currencies['EUR'] = '€'
    currencies['USD'] = '$'
    currencies['PND'] = '£'
    $('.book-detail-div').on('click', function(event){
        event.stopPropagation();
    });

    $('body').on('click', function () {
        closeBookDetail();
    });

    $('#close-book-detail-icon').click(function () {
        closeBookDetail();
    });

});

function closeAndOpenBookDetail(book, bookId) {
    bookDetailAnimationBusy = true;
    var detail = $('.book-detail-div');
    TweenLite.to(detail, 1, {
        right: "-700px",
        ease:Power1.easeOut,
        onComplete: function () {
            bookDetailAnimationBusy = false;
            detail.removeClass('visible');
            fillInBookInfo(book);
            openBookDetail(bookId);
        }
    });
}

function closeBookDetail() {
    bookDetailAnimationBusy = true;
    var detail = $('.book-detail-div');
    TweenLite.to(detail, 1, {
        right: "-700px",
        ease:Power1.easeOut,
        onComplete: function () {
            bookDetailAnimationBusy = false;
            detail.removeClass('visible');
        }
    });
}

function openBookDetail(bookId) {
    bookDetailAnimationBusy = true;
    var detail = $('.book-detail-div');
    TweenLite.to(detail, 1, {
        right: "0px",
        ease:Power1.easeOut,
        onComplete: function () {
            bookDetailAnimationBusy = false;
            detail.addClass('visible');
        }
    });
}

function fillInBookInfo(book) {
    if (book.personal_book_info.owned == 1) {
        $('#book-detail-owned').prop('checked', true);
    } else {
        $('#book-detail-owned').prop('checked', false);
    }
    if (book.personal_book_info.read == 1) {
        $('#book-detail-read').prop('checked', true);
    } else {
        $('#book-detail-read').prop('checked', false);
    }

    $('#book-detail-title').text(book.title);
    $('#book-detail-subtitle').text(book.subtitle);
    var bookImageObject = getBookImageObject(book);
    $('#book-detail-coverimage').attr('style', getImageStyle(bookImageObject.height, bookImageObject.width, bookImageObject.imageString, bookImageObject.spritePointer) + "margin: 0px;");

    $('#book-detail-author').text(book.authors[0].firstname + " " + book.authors[0].infix + " " + book.authors[0].name);
    showOrHide($('#book-detail-isbn'), book.ISBN);
    showOrHide($('#book-detail-publisher'), book.publisher.name);
    showOrHide($('#book-detail-country'), book.country.name);
    if(book.language !=null){
        showOrHide($('#book-detail-language'), book.language.language);
    }
    showOrHide($('#book-detail-genre'), book.genre.name);
    showOrHide($('#book-detail-publication-date'), dateToString(book.publication_date));
    $('#book-detail-summary').text(book.summary);
    if (book.serie != null) {
        showOrHide($('#book-detail-serie'), book.serie.name);
    } else {
        $('#book-detail-serie').parent().parent().hide();
    }
    if (book.publisher_serie != null) {
        showOrHide($('#book-detail-publisher-serie'), book.publisher_serie.name);
    } else {
        $('#book-detail-publisher-serie').parent().parent().hide();
    }

    $('#book-detail-summary').shorten({
        moreText: 'meer',
        lessText: 'minder',
        showChars: '200'
    });

    // FIRST PRINT

    if (book.first_print_info != null) {
        $('book-detail-small-info-panel').show();
        showOrHide($('#book-detail-first-print-title'), book.first_print_info.title);
        showOrHide($('#book-detail-first-print-subtitle'), book.first_print_info.subtitle);
        showOrHide($('#book-detail-first-print-isbn'), book.first_print_info.ISBN);
        showOrHide($('#book-detail-first-print-publication-date'), dateToString(book.first_print_info.publication_date));
        if (book.first_print_info.country != null) {
            showOrHide($('#book-detail-first-print-country'), book.first_print_info.country.name);
        } else {
            showOrHide($('#book-detail-first-print-country'), '');
        }
        if (book.first_print_info.language != null) {
            showOrHide($('#book-detail-first-print-language'), book.first_print_info.language.language);
        } else {
            showOrHide($('#book-detail-first-print-language'), '');
        }
        if (book.first_print_info.publisher != null) {
            showOrHide($('#book-detail-first-print-publisher'), book.first_print_info.publisher.name);
        } else {
            showOrHide($('#book-detail-first-print-publisher'), '');
        }
    } else {
        $('book-detail-small-info-panel').hide();
    }
    // EXTRA INFO
    showOrHide($('#book-detail-retail-price'), currencies[book.currency] + " " + book.retail_price);
    showOrHide($('#book-detail-number-of-pages'), book.number_of_pages);
    showOrHide($('#book-detail-print'), book.print);
    showOrHide($('#book-translator'), book.translator);

    //REVIEW
    showOrHide($('#book-detail-review'), book.personal_book_info.review);
    //BUY OR GIFT
    if (book.personal_book_info.buy_info == null) {
        $('.buy-info-tr').hide();
        $('.gift-info-tr').show();
        showOrHide($('#book-detail-gift-info-from'), book.personal_book_info.gift_info.from);
        showOrHide($('#book-detail-gift-info-occasion'), book.personal_book_info.gift_info.occasion);
        showOrHide($('#book-detail-gift-info-date'), dateToString(book.personal_book_info.gift_info.receipt_date));
        showOrHide($('#book-detail-gift-info-reason'), book.personal_book_info.gift_info.reason);
    } else {
        $('.buy-info-tr').show();
        $('.gift-info-tr').hide();
        showOrHide($('#book-detail-buy-info-date'), stringToFormattedDate(book.personal_book_info.buy_info.buy_date));
        showOrHide($('#book-detail-buy-info-price-payed'), book.personal_book_info.buy_info.price_payed + " " + book.personal_book_info.buy_info.currency);
        showOrHide($('#book-detail-buy-info-shop'), book.personal_book_info.buy_info.shop);
        if (book.personal_book_info.buy_info.city != null) {
            showOrHide($('#book-detail-buy-info-city'), book.personal_book_info.buy_info.city.name);
            if (book.personal_book_info.buy_info.city.country != null) {
                showOrHide($('#book-detail-buy-info-country'), book.personal_book_info.buy_info.city.country.name);
            }
        }
        showOrHide($('#book-detail-buy-info-reason'), book.personal_book_info.buy_info.reason);
    }

    $('#star-detail').raty({
        score: book.personal_book_info.rating,
        number: 10,
        readOnly: true,
        path: baseUrl + "/" + 'assets/lib/raty-2.7.0/lib/images'
    });

    //fix fixed div position
    $('#book-detail-container').css('margin-top', $('#book-detail-close-div').outerHeight() + 10);
}

function showOrHide(element, value) {
    if (value === "" || value == 0 || value == null) {
        element.parent().parent().hide();
    } else {
        element.text(value);
        element.parent().parent().show();
    }
}

function dateToString(date) {
    if (date != null) {
        result = "";
        if (date.day != "0" && date.day != null) {
            result = date.day + "-";
        }
        if (date.month != "0" && date.month != null) {
            result = result + date.month + "-";
        }
        if (date.year != "0" && date.year != null) {
            result = result + date.year;
        }
        return result
    }
    return "";
}

function stringToFormattedDate(dateString) {
    if (dateString != "" && dateString != null) {
        var parts = dateString.split('-');
        return parts[2] + "-" + parts[1] + "-" + parts[0];
    }
    return "";
}

function addSlidingPanelClickToElement(element){
    element.click(function (event) {
        event.stopPropagation();
        if (bookDetailAnimationBusy === false) {
            var div = $('.book-detail-div');
            var bookId = $(this).attr('bookId');

            if(div.hasClass('visible') && lastClickedBookId == bookId){
                closeBookDetail();
            }else{
                showLoadingDialog();
                $.get(window.baseUrl + "/getFullBook?" + "book_id=" + bookId,
                    function (data, status) {
                        hideLoadingDialog();
                        if (status === "success") {
                            var book = data[0];
                            if (div.hasClass('visible') && lastClickedBookId !== bookId) {
                                closeAndOpenBookDetail(book, bookId);
                                lastClickedBookId = bookId;
                            } else if (div.hasClass('visible') === false) {
                                fillInBookInfo(book);
                                openBookDetail(bookId);
                                lastClickedBookId = bookId;
                            }
                        }
                    }
                );
            }

        }
    });
}