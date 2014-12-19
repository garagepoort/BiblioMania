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
                    {{ Form::text('book_title', '', array('class' => 'form-control', 'placeholder' => 'titel', 'required' => 'true', 'type' => 'text')); }}
                </div>
            </div>

            <!-- SUBTITLE -->
            <div class="form-group">
                {{ Form::label('subtitleLabel', 'Ondertitel:', array('class' => 'col-md-2 label-gray')); }}
                <div class="col-md-9">
                    {{ Form::text('book_subtitle', '', array('class' => 'form-control', 'placeholder' => 'ondertitel', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- AUTHOR -->
                {{ Form::label('authorLabel', 'Auteur:', array('class' => 'col-md-2')); }}
                <div class="col-md-5">
                    {{ Form::text('book_author', '', array('id'=>'book_author','class' => 'form-control typeahead', 'placeholder' => 'auteur', 'required' => 'true', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- ISBN -->
                {{ Form::label('isbnLabel', 'ISBN:', array('class' => 'col-md-2', 'for' => 'book_isbn')); }}
                <div class="col-md-5">
                    {{ Form::text('book_isbn', '', array('class' => 'form-control', 'placeholder' => 'isbn', 'required' => 'true', 'type' => 'number')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- PAGES -->
                {{ Form::label('authorLabel', 'Paginas:', array('class' => 'col-md-2')); }}
                <div class="col-md-2">
                    {{ Form::text('book_number_of_pages', '', array('id'=>'book_number_of_pages','class' => 'form-control', 'placeholder' => 'paginas', 'type' => 'number')); }}
                </div>
                <!-- PRINT -->
                {{ Form::label('printLabel', 'Print:', array('class' => 'col-md-1')); }}
                <div class="col-md-2">
                    {{ Form::text('book_print', '', array('class' => 'form-control', 'placeholder' => 'print', 'type' => 'number')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- COUNTRY -->
                    {{ Form::label('bookCountryLabel', 'Land:', array('class' => 'col-md-2')); }}
                    <div class="col-md-5">
                        <select id="bookCountrySelect" name="book_countryId" class="input-sm">
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                <!-- LANGUAGE -->
                {{ Form::label('bookLanguageLabel', 'Taal:', array('class' => 'col-md-1', 'style' => 'text-align: right')); }}
                <div class="col-md-3">
                    <select id="bookLanguageSelect" name="book_languageId" class="input-sm">
                        @foreach($languages as $language)
                        <option value="{{ $language->id }}">{{ $language->language }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <!-- PUBLISHER -->
                {{ Form::label('publisherLabel', 'Uitgever:', array('class' => 'col-md-2')); }}
                <div class="col-md-5">
                    {{ Form::text('book_publisher', '', array('id'=>'publisher','class' => 'form-control', 'placeholder' => 'publisher', 'required' => 'true', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- PUBLICATION DATE -->
                {{ Form::label('bookPublicationDateInfo', 'Publicatie:', array('class' => 'col-md-2')); }}
                <div class="col-md-3">
                    {{ Form::text('book_publication_date', '', array('class' => 'input-sm datepicker', 'placeholder' => 'select date', 'required' => 'true')); }}
                </div>
            </div>

           <!-- GENRE -->
           <div class="form-group">
                {{ Form::label('bookGenreLabel', 'Genre:', array('class' => 'col-md-2')); }}
                <input id="book_genre_input" type="text" name="book_genre" hidden>
                
                <div class="well genres-container col-md-8">
                    <div class="collapsible genres-header"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Genres:</div>
                    <div>
                        @include('book/create/genreList', array('genres' => $genres))
                    </div>
                </div>
            </div>

            <!-- IMAGE -->
            <div class="form-group">
              {{ Form::label('imageBookLabel', 'Cover:', array('class' => 'col-md-2')); }}
                <!-- {{ $errors->first('book_image') }} -->
              <div class="col-md-4">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                    <div>
                      <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>{{ Form::file('book_cover_image') }}</span>
                      <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                  </div>
              </div>

                <!-- {{ Form::label('bookTypeOfCoverLabel', 'Cover type:', array('class' => 'col-md-2')); }} -->
                <!-- {{ $errors->first('book_typeOfCover') }} -->
                <div class="col-md-4">
                    <select id="bookTypeOfCoverSelect" name="book_type_of_cover" class="input-sm">
                        @foreach($covers as $cover)
                        <option value="{{ $cover }}">{{ $cover }}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
        </div>

    </fieldset>
</div>

<script type="text/javascript">
    var authors_json = {{ $authors_json }};
    var author_names = [];
    $.each(authors_json, function(index, obj){
        author_names[author_names.length] = obj.name + ', ' + obj.firstname;
    });
</script>
 {{ HTML::script('assets/js/creatBook/bookInfo.js'); }}