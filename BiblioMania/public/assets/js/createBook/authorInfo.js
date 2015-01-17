$(function() {

    var lastKnownAuthor;
    var lastSetAuthorName;
    var lastSetAuthorFirstname;
    var lastSetAuthorInfix;

    if($('#book-id-input').val() !== ''){

    }

    $('#author-info-tab-link').click(function(){
        var trimmedValue = $('#book_author_input').val();
        var result = trimmedValue.split(",");
        if(lastSetAuthorName !== result[0].trim() || lastSetAuthorFirstname !== result[1].trim()){
            $("#author_name").val(result[0].trim());
            $("#author_firstname").val(result[1].trim());
            lastSetAuthorName = result[0].trim();
            lastSetAuthorFirstname = result[1].trim();
            fillInOeuvre();
        }
    });

    $('#author_name').focusout(function(){
        $('#book_author_input').val($("#author_name").val() + ", " + $("#author_firstname").val());
        if(lastSetAuthorName !== $("#author_name").val()){
            fillInOeuvre();
            lastSetAuthorName = $("#author_name").val();
        }
    });

    $('#author_firstname').focusout(function(){
        $('#book_author_input').val($("#author_name").val() + ", " + $("#author_firstname").val());
         if(lastSetAuthorFirstname !== $("#author_firstname").val()){
            fillInOeuvre();
            lastSetAuthorFirstname = $("#author_firstname").val();
        }
    });

    function fillInOeuvre(){
        var author = $.grep(authors_json, function(e){ return e.name === $("#author_name").val() && e.firstname === $("#author_firstname").val(); })[0];
        if(author != null){
            var oeuvre;
            $.get(baseUrl + "/getOeuvreForAuthor/" + author.id,
            function(data,status){
                if(status === "success"){
                    oeuvre = data;
                    lastKnownAuthor = author;
                    createOeuvreList(oeuvre);
                }
            }).fail(function(){
            });
        }else{
            $('#oeuvre-textarea').val('');
            lastKnownAuthor = null;
            $('#author-oeuvre-list').empty();
            unlink();
        }
    }

    function createOeuvreList(oeuvre){
        var res = $('#oeuvre-textarea').val().split("\n");
        var list= ""

        if(lastKnownAuthor !== null){
            $.each(oeuvre, function(index, obj){
                list = list + "<li bookFromAuthorTitle='" + obj.title + "'>";
                if(obj.books.length == 0){
                    list = list + obj.title;
                }else{
                    list = list + "<span class='author-oeuvre-linked-book-title'>" + obj.title + "</span>";
                }
                if(obj.title === $('#book-from-author-id-input').val()){
                    list = list + "<span class='author-oeuvre-link-icon fa fa-chain linked'></span><span id='active-linked' class='green-linked-div'>linked</b></span>";
                }else{
                    list = list + "<span class='author-oeuvre-link-icon fa fa-chain-broken'></span>";
                }
                list = list +'</li>'
            });
        }

        $.each(res, function(index, obj){
            var splitString = obj.split(" - ");
            var year = splitString[0];
            var title = splitString[1];
            if(title){
                list = list + "<li bookFromAuthorTitle='" + title + "'>";
                list = list + title;
                list = list + "<span class='author-oeuvre-link-icon fa fa-chain-broken'></span>";
                list = list + '</li>'
            }
        });

        $('#author-oeuvre-list').html(list);

        $('.author-oeuvre-link-icon').on('click', function(event) {
            if(!$(this).hasClass('linked')){
                unlink();
                link($(this));
            }else{
                unlink();
            }
        });
    }

    function unlink(){
        $('#active-linked').remove();
        var linkedIcon = $('.linked');
        linkedIcon.removeClass('fa-chain');
        linkedIcon.addClass('fa-chain-broken');
        linkedIcon.removeClass('linked');
        $('#book-from-author-id-input').val('');
    }

    function link(linkedIcon){
        linkedIcon.parent().append("<span id='active-linked' class='green-linked-div'>linked</b></span>");
        linkedIcon.removeClass('fa-chain-broken');
        linkedIcon.addClass('fa-chain');
        linkedIcon.addClass('linked');
        $('#book-from-author-id-input').val(linkedIcon.parent().attr('bookFromAuthorTitle'));
    }

    $('.oeuvre-edit-icon').on('click', function(){
        if($('#oeuvre-textarea-panel').is(":visible")){
            createOeuvreList();
            $('#oeuvre-textarea-panel').hide();
        }else{
            $('#oeuvre-textarea-panel').show();
        }
    });

    $('#oeuvreButton').on('click', function(){
        if($('#oeuvre-textarea-panel').is(":visible")){
            createOeuvreList();
            $('#oeuvre-textarea-panel').hide();
        }
    });

});