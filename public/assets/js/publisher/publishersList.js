$(document).ready(function () {
    $.fn.editable.defaults.mode = 'inline';

    $('#publisherEditList').DataTable({
        paging: false
    });

    var publisher1_id = sessionStorage.getItem('publisher1_id');
    var publisher2_id = sessionStorage.getItem('publisher2_id');

    $("input[publisher-id=" + publisher1_id + "]").prop('checked', true);
    $("input[publisher-id=" + publisher2_id + "]").prop('checked', true);
    fillInMergePanel();


    $(".namePublisher").editable({
        validate: function (value) {
            if ($.trim(value) == '') {
                return 'This field is required';
            }
        }
    });

    $('#mergePublishersButton').on('click', function () {
        showPublisherMergeDialog();
    });

    $('.publisherlist-goto').on('click', function () {
        var trElement = $(this).parent().parent();
        var publisherId = trElement.attr('publisher-id');
        window.location.href = baseUrl + "/publisher/" + publisherId;
    });

    $('.publisherlist-cross').on('click', function () {
        var trElement = $(this).parent().parent();
        var publisherId = trElement.attr('publisher-id');
        showConfirmDialog('Bent u zeker dat u de uitgever wilt verwijderen?', '', function () {
            $.post(baseUrl + "/deletePublisher",
                {
                    publisherId: publisherId
                },
                function (data, status) {
                    if (status === "success") {
                        trElement.remove();
                        BootstrapDialog.show({
                            message: 'Succesvol verwijdert!'
                        });
                    }
                }).fail(function (data) {
                    BootstrapDialog.show({
                        message: data.responseJSON.message
                    });
                });
        }, function () {
        });
    });

    $('.merge-publisher-checkbox').on('change', function () {
        var publisherId = $(this).attr('publisher-id');
        var publisher1_id = sessionStorage.getItem('publisher1_id');
        var publisher1_name = sessionStorage.getItem('publisher1_name');
        var publisher2_id = sessionStorage.getItem('publisher2_id');
        var publisher2_name = sessionStorage.getItem('publisher2_name');

        if ($(this).is(':checked')) {
            if (!publisher1Selected()) {
                sessionStorage.setItem('publisher1_id', publisherId);
                sessionStorage.setItem('publisher1_name', $("a[data-pk=" + publisherId + "]").text());
            } else {
                $("input[publisher-id=" + publisher2_id + "]").prop('checked', false);
                sessionStorage.setItem('publisher2_id', publisherId);
                sessionStorage.setItem('publisher2_name', $("a[data-pk=" + publisherId + "]").text());
            }
        } else {
            if (publisher1_id === publisherId) {
                sessionStorage.removeItem('publisher1_id');
                sessionStorage.removeItem('publisher1_name');
            } else if (publisher2_id === publisherId) {
                sessionStorage.removeItem('publisher2_id');
                sessionStorage.removeItem('publisher2_name');
            }
        }
        fillInMergePanel();
    });

    function fillInMergePanel() {
        var publisher1_id = sessionStorage.getItem('publisher1_id');
        var publisher1_name = sessionStorage.getItem('publisher1_name');
        var publisher2_id = sessionStorage.getItem('publisher2_id');
        var publisher2_name = sessionStorage.getItem('publisher2_name');

        if (publisher1Selected() || publisher2Selected()) {

            $('#publisher-merge-list').empty();
            $('#selectMergePublisher').empty();

            if (publisher1Selected()) {
                $('#publisher-merge-list').append('<li>' + publisher1_name + '</li>');
                $("#selectMergePublisher").append($("<option>")
                        .val(publisher1_id)
                        .html(publisher1_name)
                );
            }

            if (publisher2Selected()) {
                $('#publisher-merge-list').append('<li>' + publisher2_name + '</li>');
                $("#selectMergePublisher").append($("<option>")
                        .val(publisher2_id)
                        .html(publisher2_name)
                );
            }

            if (publisher1Selected() && publisher2Selected()) {
                $('#mergePublishersButton').prop("disabled", false);
                $('#selectMergePublisher').show();
            } else {
                $('#mergePublishersButton').prop("disabled", true);
                $('#selectMergePublisher').hide();
            }

            $('#publisher-list-merge-container').show();
        } else {
            $('#publisher-list-merge-container').hide();
        }
    }

    function showPublisherMergeDialog() {
        var mergePublisherId = $('#selectMergePublisher').val();
        var publisher1_id = sessionStorage.getItem('publisher1_id');
        var publisher1_name = sessionStorage.getItem('publisher1_name');
        var publisher2_id = sessionStorage.getItem('publisher2_id');
        var publisher2_name = sessionStorage.getItem('publisher2_name');


        var message = 'Uitgever 1: ' + publisher1_name + '\n';
        message = message + 'Uitgever 2: ' + publisher2_name;

        showConfirmDialog('Ben je zeker dat je deze uitgevers wilt samenvoegen?', message,
            function () {
                $.post(baseUrl + "/mergePublishers",
                    {
                        publisher1_id: publisher1_id === mergePublisherId ? publisher1_id : publisher2_id,
                        publisher2_id: publisher2_id === mergePublisherId ? publisher1_id : publisher2_id
                    },
                    function (data, status) {
                        if (status === "success") {
                            emptySessionStorage();
                            dialogItself.close();
                            BootstrapDialog.show({
                                message: 'Succesvol samengevoegd!'
                            });
                        }
                    }).fail(function (data) {
                        emptySessionStorage();
                        BootstrapDialog.show({
                            message: data.responseJSON.message
                        });
                    });
            },
            function () {
                emptySessionStorage();
                fillInMergePanel();
            });
    }

    function publisher1Selected() {
        var publisher1_id = sessionStorage.getItem('publisher1_id');

        return publisher1_id !== 'undefined' && publisher1_id !== null;
    }

    function publisher2Selected() {
        var publisher2_id = sessionStorage.getItem('publisher2_id');

        return publisher2_id !== 'undefined' && publisher2_id !== null;
    }

    function emptySessionStorage() {
        var publisher1_id = sessionStorage.getItem('publisher1_id');
        var publisher2_id = sessionStorage.getItem('publisher2_id');
        $("input[publisher-id=" + publisher1_id + "]").prop('checked', false);
        $("input[publisher-id=" + publisher2_id + "]").prop('checked', false);
        sessionStorage.removeItem('publisher1_id');
        sessionStorage.removeItem('publisher1_name');
        sessionStorage.removeItem('publisher2_id');
        sessionStorage.removeItem('publisher2_name');
    }
});
