@extends('main')
@section('title')
    <span id="book-info-title">{{ $book_title }}</span>
@stop
@section('content')
    <div class="create-book-div">
        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => 'createOrEditBook', 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
        <input id="book-id-input" name="book_id" hidden value={{ $book_id }}>

        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a id="book-info-tab-link" href="#home" aria-controls="home"
                                                          role="tab" data-toggle="tab">Boek</a></li>
                <li role="presentation">
                    <a id="extra-info-tab-link" href="#extra" aria-controls="home" role="tab" data-toggle="tab">Extra
                        boek info</a></li>
                <li role="presentation">
                    <a id="author-info-tab-link" href="#authorTab" aria-controls="authorTab"
                       role="tab" data-toggle="tab">Auteur</a>
                </li>
                <li role="presentation">
                    <a id="first-print-info-tab-link" href="#first_print_info_tab"
                       aria-controls="first_print_info_tab" role="tab" data-toggle="tab">Eerste
                        druk</a>
                </li>
                <li role="presentation">
                    <a id="personal-info-tab-link" href="#personal_info_tab" aria-controls="personal_info_tab"
                       role="tab" data-toggle="tab">Persoonlijke info</a>
                </li>
                <li role="presentation"><a id="buy-info-tab-link" href="#buy_info_tab" aria-controls="buy_info_tab"
                                           role="tab" data-toggle="tab">Koop info</a>
                </li>
                <li role="presentation"><a id="cover-tab-link" href="#cover_tab" aria-controls="cover_tab" role="tab"
                                           data-toggle="tab">Cover info</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div id="error-div" class="material-card error-message" hidden>
                <div id="error-message" class="material-card-content error-message"></div>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    @include('book/create/bookInfo')
                </div>
                <div role="tabpanel" class="tab-pane" id="extra">
                    @include('book/create/extraBookInfo')
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
                <div role="tabpanel" class="tab-pane" id="buy_info_tab">
                    @include('book/create/buyOrGiftInfo')
                </div>
                <div role="tabpanel" class="tab-pane" id="cover_tab">
                    @include('book/create/coverInfo')
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="saveBetalingbutton"></label>

            <div class="controls">
                {{ Form::submit('Boek opslaan', array('id'=>'bookSubmitButton', 'class'=> 'btn btn-success', 'onclick' => 'return validateForm();')); }}
            </div>
        </div>
        {{ Form::close(); }}

        <script type="text/javascript">
            var country_json = {{ $countries_json }};
            var country_names = [];
            $.each(country_json, function (index, obj) {
                country_names[country_names.length] = obj.name;
            });
        </script>
        {{ HTML::script('assets/js/createBook/createBook.js'); }}

    </div>

@stop
