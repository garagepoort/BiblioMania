@extends('main')
@section("title")
    {{ $title }}
@endsection
@section("content")
    <div class="wizard-steps">
        @include('book/wizard/wizardsteps', array('wizardSteps' => $wizardSteps, 'currentStep' => '1'))
    </div>
    <div class="create-book-div">

        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => 'createOrEditBook/step/1/' . $book_id, 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
        <div id="error-div" class="material-card error-message" hidden>
            <div id="error-message" class="material-card-content error-message"></div>
        </div>
        <input id="book-id-input" name="book_id" hidden value={{ $book_id }}>

        <fieldset>

            <legend>Boek info</legend>
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
                    {{ Form::label('titleLabel', 'Titel:', array('class' => 'col-md-2')); }}
                    <div class="col-md-9">
                        {{ Form::text('book_title', $book_title, array('id'=>'book_title_input', 'class' => 'form-control', 'placeholder' => 'titel', 'required' => 'true', 'type' => 'text')); }}
                    </div>
                </div>

                <!-- SUBTITLE -->
                <div class="form-group">
                    {{ Form::label('subtitleLabel', 'Ondertitel:', array('class' => 'col-md-2 label-gray')); }}
                    <div class="col-md-9">
                        {{ Form::text('book_subtitle', $book_subtitle, array('id'=>'book_subtitle_input', 'class' => 'form-control', 'placeholder' => 'ondertitel', 'type' => 'text')); }}
                    </div>
                </div>

                <!-- ISBN -->
                <div class="form-group">
                    {{ Form::label('isbnLabel', 'ISBN:', array('class' => 'col-md-2', 'for' => 'book_isbn')); }}
                    <div class="col-md-5">
                        {{ Form::text('book_isbn', $book_isbn, array('id'=>'book_isbn_input', 'class' => 'form-control', 'placeholder' => 'isbn', 'required' => 'true', 'type' => 'number')); }}
                    </div>
                    <div class="col-md-5">
                        <button id="searchGoogleInformationButton" class="btn btn-primary" onclick="return false;">Zoek
                            boek informatie
                        </button>
                    </div>
                </div>

                <!-- GENRE -->
                <div class="form-group">
                    {{ Form::label('bookGenreLabel', 'Genre:', array('class' => 'col-md-2')); }}
                    <input id="book_genre_input" type="text" name="book_genre" hidden required
                           value={{ $book_genre_input }}>

                    <div class="genres-container col-md-8">
                        <div class="collapsible genres-header list-group-item" id="genres-header"><span id="genresGlyphicon"
                                                                                        class="glyphicon glyphicon-chevron-right"
                                                                                        aria-hidden="true">    Genres:</span>
                        </div>
                        <div>
                            @include('book/create/genre/genreList', array('genres' => $genres))
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                <div class="form-group">
                    {{ Form::label('tagLabel', 'Tags:', array('class' => 'col-md-2')); }}
                    <div class="col-md-9">
                        {{ Form::text('book_tags', $book_tags, array('id'=>'tag_input', 'class' => 'form-control', 'type' => 'text')); }}
                    </div>
                </div>


                <legend>Uitgever</legend>

                <div class="form-group">
                    <!-- PUBLISHER -->
                    {{ Form::label('publisherLabel', 'Uitgever:', array('class' => 'col-md-2')); }}
                    <div class="col-md-5">
                        {{ Form::text('book_publisher', $book_publisher, array('id'=>'book_publisher_input','class' => 'form-control', 'placeholder' => 'publisher', 'required' => 'true', 'type' => 'text')); }}
                    </div>
                </div>

                <div class="form-group">
                    <!-- PUBLICATION DATE -->
                    {{ Form::label('', 'Publicatie:', array('class' => 'col-md-2 label-gray' )); }}
                    <div class="col-md-7">
                        @include('book/create/dateInputFragment', array('label' => 'Publicatie',
                                                    'dateDayName'=>'book_publication_date_day',
                                                    'dateMonthName'=>'book_publication_date_month',
                                                    'dateYearName'=>'book_publication_date_year',
                                                    'dateDayValue' => $book_publication_date_day,
                                                    'dateMonthValue' => $book_publication_date_month,
                                                    'dateYearValue' => $book_publication_date_year
                                                    ))
                    </div>
                </div>

                <div class="form-group">
                    <!-- COUNTRY -->
                    {{ Form::label('bookCountryLabel', 'Land:', array('class' => 'col-md-2')); }}
                    <div class="col-md-5">
                        {{ Form::text('book_country', $book_country, array('id'=>'book_country','class' => 'form-control typeahead', 'placeholder' => 'land', 'required' => 'true', 'type' => 'text')); }}
                    </div>

                    <!-- LANGUAGE -->
                    {{ Form::label('bookLanguageLabel', 'Taal:', array('class' => 'col-md-1', 'style' => 'text-align: right')); }}
                    <div class="col-md-3">
                        {{ Form::select('book_language', $languages, $book_language, array('class' => 'input-sm form-control')); }}
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="bookSubmitButton"></label>

                    <div class="controls">
                        {{ Form::submit('Volgende', array('id'=>'bookNextButton', 'class'=> 'btn btn-success', 'onclick' => 'return validateForm();')); }}
                    </div>
                </div>
            </div>

        </fieldset>
        {{ Form::close(); }}
    </div>

    <script type="text/javascript">
        var authors_json = {{ $authors_json }};
        var publishers_json = {{ $publishers_json }};
        var tags_json = {{ $tags_json }};
        var country_json = {{ $countries_json }};
        var author_names = [];
        var publisher_names = [];
        var tags = [];
        var country_names = [];
        $.each(authors_json, function (index, obj) {
            if (obj.infix != '') {
                author_names[author_names.length] = obj.name + ', ' + obj.infix + ', ' + obj.firstname;
            } else {
                author_names[author_names.length] = obj.name + ', ' + obj.firstname;
            }
        });
        $.each(publishers_json, function (index, obj) {
            publisher_names[publisher_names.length] = obj.name;
        });
        $.each(tags_json, function (index, obj) {
            tags[tags.length] = obj.name;
        });
        $.each(country_json, function (index, obj) {
            country_names[country_names.length] = obj.name;
        });
    </script>
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
    {{ HTML::script('assets/js/book/wizard/bookBasics.js'); }}
@endsection
@stop