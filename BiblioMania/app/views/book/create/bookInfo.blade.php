<div class="tab-container ">
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

            <div class="form-group">
                <!-- AUTHOR -->
                {{ Form::label('authorLabel', 'Auteur:', array('class' => 'col-md-2')); }}
                <div class="col-md-5">
                    {{ Form::text('book_author', $author_name . ', ' . $author_firstname , array('id'=>'book_author_input','class' => 'form-control typeahead', 'placeholder' => 'auteur', 'required' => 'true', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- ISBN -->
                {{ Form::label('isbnLabel', 'ISBN:', array('class' => 'col-md-2', 'for' => 'book_isbn')); }}
                <div class="col-md-5">
                    {{ Form::text('book_isbn', $book_isbn, array('id'=>'book_isbn_input', 'class' => 'form-control', 'placeholder' => 'isbn', 'required' => 'true', 'type' => 'number')); }}
                </div>
            </div>

           <!-- GENRE -->
           <div class="form-group">
                {{ Form::label('bookGenreLabel', 'Genre:', array('class' => 'col-md-2')); }}
                <input id="book_genre_input" type="text" name="book_genre" hidden required value={{ $book_genre_input }}>
                
                <div class="genres-container col-md-8">
                    <div class="collapsible genres-header" id="genres-header"><span id="genresGlyphicon" class="glyphicon glyphicon-chevron-right" aria-hidden="true">    Genres:</span></div>
                    <div>
                        @include('book/create/genreList', array('genres' => $genres))
                    </div>
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
                {{ Form::label('', 'Publicatie:', array('class' => 'col-md-2')); }}
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
                    {{ Form::select('book_languageId', $languages, $book_languageId, array('class' => 'input-sm')); }}
                </div>
            </div>
        </div>

    </fieldset>
</div>

<script type="text/javascript">
    var authors_json = {{ $authors_json }};
    var publishers_json = {{ $publishers_json }};
    var author_names = [];
    var publisher_names = [];
    $.each(authors_json, function(index, obj){
        author_names[author_names.length] = obj.name + ', ' + obj.firstname;
    });
    $.each(publishers_json, function(index, obj){
        publisher_names[publisher_names.length] = obj.name;
    });
</script>
 {{ HTML::script('assets/js/createBook/bookInfo.js'); }}