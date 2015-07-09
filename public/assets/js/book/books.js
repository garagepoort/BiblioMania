$(document).ready(function () {
    nextBooksUrl = "/getNextBooks?";

    if (window.book_id != null) {
        startLoadingPaged(window.baseUrl + nextBooksUrl + "book_id=" + window.book_id, 1, fillInBookContainer);
    } else {
        startLoadingPaged(window.baseUrl + nextBooksUrl, 1, fillInBookContainer);
    }

    $('#orderby-select-box').change(function () {
        doSearchBooks();
    });


    function doSearchBooks() {
        window.book_id = null;
        var query = $('#searchBooksInput').val();
        var operator = $('#search_param_operator').val();
        var type = $('#search_param_type').val();
        var ownedVal = $(".ownedFilterRadioButton input.selected").val();
        var readVal = $(".readFilterRadioButton input.selected").val();
        var url = window.baseUrl + "/getNextBooks?query=" + query
            + "&order_by=" + $('#orderby-select-box').val()
            + "&operator=" + operator
            + "&type=" + type
            + "&read=" + readVal
            + "&owned=" + ownedVal;
        $('#books-container-table > tbody').empty();
        abortLoadingPaged();
        startLoadingPaged(url, 1, fillInBookContainer);
    }

    function doFilterBooks() {
        var url = window.baseUrl + "/getNextBooks?";
        var params = {
            bookTitle: $('#title-filter-input').val(),
            book_subtitle: $('#subtitle-filter-input').val(),
            book_author_name: $('#author-name-filter-input').val(),
            book_author_firstname: $('#author-firstname-filter-input').val()
        };
        url = url + jQuery.param(params);

        $('#books-container-table > tbody').empty();
        abortLoadingPaged();
        startLoadingPaged(url, 1, fillInBookContainer);
    }

    $("#searchBooksInput").keyup(function (e) {
        if (e.keyCode == 13) {
            doSearchBooks();
        }
    });

    $('#searchBooksButton').on('click', function () {
        doSearchBooks();
    });

    $('#book-filters-button').on('click', function () {
        doFilterBooks();
    });

    function addCapSlideToElement(element) {
        element.capslide({
            showcaption: false,
            overlay_bgcolor: ""
        });
    }

    function addLazyLoading(imageElement){
        $(imageElement).lazyLoadXT();
    }

    function addClickToEditElement(element, bookId) {
        element.click(function (event) {
            window.location = baseUrl + "/editBook/" + bookId;
            event.stopPropagation();
        });
    }

    function fillInBookContainer(data) {
        var books = data.data;
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
                var materialCard = createMaterialCardImage(bookImageObject.imageString, bookImageObject.height, bookImageObject.width, bookImageObject.spritePointer);
                materialCard.attr("bookid", book.id);

                var icCaptionElement = $("<div class=\"ic_caption editBookPanel\"><p class=\"ic_category\">Edit<i class=\"fa fa-pencil editImagePencilIcon\"></i></p></div>");

                materialCard.append(icCaptionElement);
                tdElement.append(materialCard);
                trElement.append(tdElement);

                addCapSlideToElement(materialCard);
                addClickToBookImage(materialCard);
                addClickToEditElement(icCaptionElement, book.id);
            }
            $('#books-container-table > tbody:last').append(trElement);
        }
    }

    function addClickToBookImage(element) {
       addSlidingPanelClickToElement(element);
    }

    $("#filterButton").click(function () {
        if ($('#book-collection-filter-panel').is(":visible")) {
            $('#book-collection-filter-panel').hide();
        } else {
            $('#book-collection-filter-panel').show();
        }
    });

    $(function () {
        $("#deselect").on("click", function (event) {
            $(".ownedFilterRadioButton").children('input.selected').removeClass('selected');
            $(".readFilterRadioButton").children('input.selected').removeClass('selected');
            $('.filterRadioButton').removeClass("active");
            doSearchBooks();
        });

        $(".ownedFilterRadioButton").on("click", function (event) {
            $(".ownedFilterRadioButton").children('input.selected').removeClass('selected');
            $(this).children('input').addClass('selected');
            doSearchBooks();
        });

        $(".readFilterRadioButton").on("click", function (event) {
            $(".readFilterRadioButton").children('input.selected').removeClass('selected');
            $(this).children('input').addClass('selected');
            doSearchBooks();
        });
    });
});