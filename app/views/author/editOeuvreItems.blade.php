<div id='edit-oeuvre-textarea-panel' hidden="true" style="margin-bottom: 20px;">
    @include('error', array("id"=>"error-div-edit-oeuvre"))
    <textarea placeholder="<id> - <jaar> - <titel>" id='edit-oeuvre-textarea' name="oeuvre" cols="80" rows="5"
              style="width: 100%"></textarea>
    <button class='btn btn-default' id='oeuvreButton' onclick="editOeuvreItems(); return false;">Pas oeuvre aan</button>
</div>

<script type="text/javascript">
    var oeuvre_json = {{ $oeuvre_json }};
    $(function () {
        hideEditOevreItems();
        fillInOeuvreTextArea();
    });

    function showEditOevreItems() {
        $('#edit-oeuvre-textarea-panel').show();
    }
    function hideEditOevreItems() {
        $('#edit-oeuvre-textarea-panel').hide();
    }

    function toggleEditOevreItems() {
        $('#edit-oeuvre-textarea-panel').toggle();
    }


    function fillInOeuvreTextArea() {
        var oeuvreString = "";
        $.each(oeuvre_json, function (index, obj) {
            oeuvreString = oeuvreString + obj.id + " - " + obj.publication_year + " - " + obj.title + "\n";
        });
        $('#edit-oeuvre-textarea').val(oeuvreString);
    }


    function editOeuvreItems() {
        var errorMessage = validateEditOeuvreList();
        if (errorMessage) {
            showError("error-div-edit-oeuvre", errorMessage);
        } else {
            hideError("error-div-edit-oeuvre");
            editOeuvre();
        }
    }

    function editOeuvre() {
        $.post(baseUrl + "/editBookFromAuthors",
                {
                    author_id: '{{ $author_id }}',
                    oeuvre: $('#edit-oeuvre-textarea').val()
                },
                function (data, status) {
                    if (status === "success") {
                        location.reload();
                    }
                }).fail(function (data) {
                    BootstrapDialog.show({
                        message: data.responseJSON.message
                    });
                });
    }


    function validateEditOeuvreList() {
        var res = $('#edit-oeuvre-textarea').val().split("\n");
        var errorMessage = null;
        if (res != null && res != "") {
            $.each(res, function (index, obj) {
                if (obj != "") {
                    var splitString = obj.split(" - ");
                    if (splitString.length < 3) {
                        errorMessage = "Formaat is id - jaar - titel";
                    } else {
                        var id = splitString[0];
                        var year = splitString[1];
                        var title = splitString[2];
                        if (!title) {
                            errorMessage = "Titel moet ingevuld zijn";
                        }
                    }
                }
            });
        }

        return errorMessage;
    }
</script>