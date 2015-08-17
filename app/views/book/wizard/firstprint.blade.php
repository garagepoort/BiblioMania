@extends('main')
@section("title")
    {{ $title }}
@endsection
@section("content")
    <div class="wizard-steps">
        @include('book/wizard/wizardsteps', array('wizardSteps' => $wizardSteps, 'currentStep' => '4', 'progress' => $book_wizard_step))
    </div>
    <div class="create-book-div">
        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => 'createOrEditBook/step/4/' . $book_id, 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
        <input id="redirectInput" hidden name="redirect" value="NEXT">
        <div id="error-div" class="material-card error-message" hidden>
            <div id="error-message" class="material-card-content error-message"></div>
        </div>

        <fieldset>
            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div id="bookInfoMessage" class="alert-danger alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
            @endif

            <div class="form-container">

                <!-- TITLE -->
                <div class="form-group">
                    {{ Form::label('firstprint_titleLabel', 'Titel:', array('class' => 'col-md-2')); }}
                    <div class="col-md-9">
                        {{ Form::text('first_print_title', $first_print_title, array('id'=>'first_print_title', 'class' => 'form-control', 'placeholder' => 'titel', 'type' => 'text')); }}
                    </div>
                </div>

                <!-- SUBTITLE -->
                <div class="form-group">
                    {{ Form::label('first_print_subtitleLabel', 'Ondertitel:', array('class' => 'col-md-2 label-gray')); }}
                    <div class="col-md-9">
                        {{ Form::text('first_print_subtitle', $first_print_subtitle, array('id'=>'first_print_subtitle', 'class' => 'form-control', 'placeholder' => 'ondertitel', 'type' => 'text')); }}
                    </div>
                </div>

                <div class="form-group">
                    <!-- ISBN -->
                    {{ Form::label('first_print_isbnLabel', 'ISBN:', array('class' => 'col-md-2')); }}
                    <div class="col-md-3">
                        {{ Form::text('first_print_isbn', $first_print_isbn, array('id'=>'first_print_isbn', 'class' => 'form-control', 'placeholder' => 'isbn', 'type' => 'number')); }}
                    </div>
                </div>

                <div class="form-group">
                    <!-- COUNTRY -->
                    {{ Form::label('first_print_CountryLabel', 'Land:', array('class' => 'col-md-2')); }}
                    <div class="col-md-5">
                        {{ Form::text('first_print_country', $first_print_country, array('id'=>'first_print_country','class' => 'form-control typeahead', 'placeholder' => 'land', 'type' => 'text')); }}
                    </div>

                    <!-- LANGUAGE -->
                    {{ Form::label('first_print_LanguageLabel', 'Taal:', array('class' => 'col-md-1', 'style' => 'text-align: right')); }}
                    <div class="col-md-3">
                        {{ Form::select('first_print_language', $languages, $first_print_language, array('class' => 'input-sm form-control', 'id' => 'first_print_info_language')); }}
                    </div>
                </div>

                <div class="form-group">
                    <!-- PUBLISHER -->
                    {{ Form::label('first_print_publisherLabel', 'Uitgever:', array('class' => 'col-md-2')); }}
                    <div class="col-md-5">
                        {{ Form::text('first_print_publisher', $first_print_publisher, array('id'=>'first_print_publisher','class' => 'form-control', 'placeholder' => 'publisher', 'type' => 'text')); }}
                    </div>
                </div>

                <div class="form-group">
                    <!-- PUBLICATION DATE -->
                    {{ Form::label('', 'Publicatie:', array('class' => 'col-md-2')); }}
                    <div class="col-md-7">
                        @include('book/create/dateInputFragment', array('label' => 'Publicatie',
                                                    'dateDayName'=>'first_print_publication_date_day',
                                                    'dateMonthName'=>'first_print_publication_date_month',
                                                    'dateYearName'=>'first_print_publication_date_year',
                                                    'dateDayValue' => $first_print_publication_date_day,
                                                    'dateMonthValue' => $first_print_publication_date_month,
                                                    'dateYearValue' => $first_print_publication_date_year
                                                    ))
                    </div>
                </div>

                @include('book/wizard/submitButtons')
            </div>

        </fieldset>
        {{ Form::close(); }}
    </div>

    <script type="text/javascript">
        var publishers_json = {{ $publishers_json }};
        var country_json = {{ $countries_json }};
        var publisher_names = [];
        var country_names = [];

        $.each(publishers_json, function (index, obj) {
            publisher_names[publisher_names.length] = obj.name;
        });
        $.each(country_json, function (index, obj) {
            country_names[country_names.length] = obj.name;
        });
    </script>
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
@endsection
@stop