@extends('main')

@section('content')
{{ Form::open(array('url' => 'createBook', 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off')); }}
<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Boek</a></li>
    <li role="presentation"><a href="#authorTab" aria-controls="authorTab" role="tab" data-toggle="tab">Auteur</a></li>
    <li role="presentation"><a href="#first_print_info_tab" aria-controls="first_print_info_tab" role="tab" data-toggle="tab">Eerste druk</a></li>
    <li role="presentation"><a href="#personal_info_tab" aria-controls="personal_info_tab" role="tab" data-toggle="tab">Persoonlijke info</a></li>
    <li role="presentation"><a href="#buy_info_tab" aria-controls="buy_info_tab" role="tab" data-toggle="tab">Koop info</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
      @include('book/create/bookInfo')
    </div>
    <div role="tabpanel" class="tab-pane" id="authorTab">
      @include('book/create/authorInfo')
    </div>
    <div role="tabpanel" class="tab-pane" id="first_print_info_tab">
      @include('book/create/firstPrintInfo')
    </div>
    <div role="tabpanel" class="tab-pane" id="personal_info_tab">
      @include('book/create/personalBookInfo')
    </div>
    <div role="tabpanel" class="tab-pane" id="buy_info_tab">...</div>
  </div>
</div>

<div class="control-group">
    <label class="control-label" for="saveBetalingbutton"></label>
    <div class="controls">
        {{ Form::submit('Boek opslaan', array('class'=> 'btn btn-primary')); }}
    </div>
</div>
{{ Form::close(); }}
<script>

  $("#book_author").bind("keyup paste", function() {
    var trimmedValue = $(this).val().replace(" ","");
    var result = trimmedValue.split(",");
    $("#author_name").val(result[0]);
    $("#author_firstname").val(result[1]);
  });

  $(document).ready(function() {
            $('.createBookForm').bootstrapValidator({
                message: 'This value is not valid',
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                  //BOOK
                    book_title: {
                        message: 'The title is not valid',
                        validators: {
                            notEmpty: {
                                message: 'De titel moet ingevuld zijn.'
                            }
                        }
                    },
                    book_author: {
                        message: 'De auteur is niet ok',
                        validators: {
                            notEmpty: {
                                message: 'De auteur moet ingevuld zijn.'
                            }
                        }
                    },
                    book_isbn: {
                        validators: {
                            regexp: {
                                regexp: '^[0-9]{13}$',
                                message: 'Exact 13 cijfers'
                            }
                        }
                    },
                    book_publisher: {
                        message: 'De uitgever is niet ingevuld',
                        validators: {
                            notEmpty: {
                                message: 'Het uitgever moet ingevuld zijn.'
                            }
                        }
                    },
                    book_print: {
                        message: 'De uitgever is niet ingevuld',
                        validators: {
                            regexp: {
                                regexp: '^[0-9]$',
                                message: 'Kan enkel cijfers zijn'
                            }
                        }
                    },
                    book_number_of_pages: {
                        message: 'De uitgever is niet ingevuld',
                        validators: {
                            regexp: {
                                regexp: '^[0-9]$',
                                message: 'Kan enkel cijfers zijn'
                            }
                        }
                    },
                    //FIRST PRINT
                    first_print_isbn: {
                         validators: {
                            regexp: {
                                regexp: '^[0-9]{13}$',
                                message: 'Exact 13 cijfers'
                            }
                        }
                    }
                }
            });
        });
  </script>


@stop
