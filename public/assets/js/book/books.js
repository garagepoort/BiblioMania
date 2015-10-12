var nextBooksUrl = "/searchBooks?";
$(document).ready(function () {

    if (window.book_id != null) {
        startLoadingPaged(window.baseUrl + nextBooksUrl + "book_id=" + window.book_id, 1, fillInBookContainer);
    } else {
        startLoadingPaged(window.baseUrl + nextBooksUrl, 1, fillInBookContainer);
    }

    $('#orderby-select-box').change(function () {
        doSearchBooks();
    });

    $("#searchBooksInput").keyup(function (e) {
        if (e.keyCode == 13) {
            doSearchBooks();
        }
    });

    $('#searchBooksButton').on('click', function () {
        doSearchBooks();
    });
});

function doSearchBooks() {
    window.book_id = null;
    var query = $('#searchBooksInput').val();
    var operator = $('#search_param_operator').val();
    var type = $('#search_param_type').val();
    var ownedVal = $(".ownedFilterRadioButton input.selected").val();
    var readVal = $(".readFilterRadioButton input.selected").val();
    var url = window.baseUrl + "/searchBooks?query=" + query
        + "&order_by=" + $('#orderby-select-box').val()
        + "&operator=" + operator
        + "&type=" + type
        + "&read=" + readVal
        + "&owned=" + ownedVal;
    $('#books-container-table > tbody').empty();
    abortLoadingPaged();
    startLoadingPaged(url, 1, fillInBookContainer);
}

function addCapSlideToElement(element) {
    element.capslide({
        showcaption: false,
        overlay_bgcolor: ""
    });
}

function addClickToEditElement(element, bookId) {
    element.click(function (event) {
        window.location = baseUrl + "/createOrEditBook/step/1/" + bookId;
        event.stopPropagation();
    });
}

function fillInBookContainer(data) {
    var scrollElement = null;
    var books = data.data;
    var library_information = data.library_information;
    fillInLibraryInformation(library_information.total_amount_books, library_information.total_amount_books_owned, library_information.total_value);
    var amountBooks = Object.keys(books).length;

    for (var i = 0; i < amountBooks / 6; i++) {
        var columns = 6;
        if (i * 6 + 6 > amountBooks) {
            columns = amountBooks % 6;
        }

        var trElement = $("<tr></tr>");
        for (j = 0; j < columns; j++) {
            var book = books[(6 * i) + j];

            var tdElement = $("<td></td>");

            var bookImageObject = getBookImageObject(book);
            var materialCard = createMaterialCardImage(book.id, bookImageObject.imageString, bookImageObject.height, bookImageObject.width, bookImageObject.spritePointer, book.hasWarnings, book.read);
            materialCard.attr("bookid", book.id);

            var icCaptionElement = $("<div class=\"ic_caption editBookPanel\"><p class=\"ic_category\">Edit<i class=\"fa fa-pencil editImagePencilIcon\"></i></p></div>");

            materialCard.append(icCaptionElement);
            tdElement.append(materialCard);
            trElement.append(tdElement);

            addCapSlideToElement(materialCard);
            addClickToBookImage(materialCard);
            addClickToEditElement(icCaptionElement, book.id);
            if (window.scroll_id != null && window.scroll_id == book.id) {
                scrollElement = materialCard[0];
                window.scroll_id = null;
            }
        }

        $('[data-toggle="tooltip"]').tooltip();

        $('#books-container-table > tbody:last').append(trElement);
    }
    if (scrollElement != null) {
        scrollToElement(scrollElement);
    }
}

function addClickToBookImage(element) {
    addSlidingPanelClickToElement(element);
}