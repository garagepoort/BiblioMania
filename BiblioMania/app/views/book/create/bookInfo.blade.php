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
                {{ $errors->first('book_title') }}
                <div class="col-md-9">
                    {{ Form::text('book_title', '', array('class' => 'form-control', 'placeholder' => 'titel', 'required' => 'true', 'type' => 'text')); }}
                </div>
            </div>

            <!-- SUBTITLE -->
            <div class="form-group">
                {{ Form::label('subtitleLabel', 'Ondertitel:', array('class' => 'col-md-2 label-gray')); }}
                {{ $errors->first('book_subtitle') }}
                <div class="col-md-9">
                    {{ Form::text('book_subtitle', '', array('class' => 'form-control', 'placeholder' => 'ondertitel', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- AUTHOR -->
                {{ Form::label('authorLabel', 'Auteur:', array('class' => 'col-md-2')); }}
                {{ $errors->first('book_author') }}
                <div class="col-md-5">
                    {{ Form::text('book_author', '', array('id'=>'book_author','class' => 'form-control', 'placeholder' => 'auteur', 'required' => 'true', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- ISBN -->
                {{ Form::label('isbnLabel', 'ISBN:', array('class' => 'col-md-2', 'for' => 'book_isbn')); }}
                {{ $errors->first('book_isbn') }}
                <div class="col-md-5">
                    {{ Form::text('book_isbn', '', array('class' => 'form-control', 'placeholder' => 'isbn', 'required' => 'true', 'type' => 'numbers')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- PAGES -->
                {{ Form::label('authorLabel', 'Paginas:', array('class' => 'col-md-2')); }}
                {{ $errors->first('book_number_of_pages') }}
                <div class="col-md-2">
                    {{ Form::text('book_number_of_pages', '', array('id'=>'book_number_of_pages','class' => 'form-control', 'placeholder' => 'paginas', 'type' => 'text')); }}
                </div>
                <!-- PRINT -->
                {{ Form::label('printLabel', 'Print:', array('class' => 'col-md-1')); }}
                {{ $errors->first('book_print') }}
                <div class="col-md-2">
                    {{ Form::text('book_print', '', array('class' => 'form-control', 'placeholder' => 'print', 'type' => 'numbers')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- COUNTRY -->
                    {{ Form::label('bookCountryLabel', 'Land:', array('class' => 'col-md-2')); }}
                    {{ $errors->first('bookCountryId') }}
                    <div class="col-md-5">
                        <select id="bookCountrySelect" name="bookCountryId" class="input-sm">
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                <!-- LANGUAGE -->
                {{ Form::label('bookLanguageLabel', 'Taal:', array('class' => 'col-md-1', 'style' => 'text-align: right')); }}
                {{ $errors->first('book_languageId') }}
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
                {{ $errors->first('book_publisher') }}
                <div class="col-md-5">
                    {{ Form::text('book_publisher', '', array('id'=>'publisher','class' => 'form-control', 'placeholder' => 'publisher', 'required' => 'true', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- PUBLICATION DATE -->
                {{ Form::label('bookPublicationDateInfo', 'Publicatie:', array('class' => 'col-md-2')); }}
                {{ $errors->first('book_publication_date') }}
                <div class="col-md-3">
                    {{ Form::text('book_publication_date', '', array('class' => 'input-sm datepicker', 'placeholder' => 'select date', 'required' => 'true', 'data-format' => 'dd-MM-yyyy')); }}
                </div>
            </div>

               <!-- GENRE -->
            <div class="form-group">
                {{ Form::label('genreLabel', 'Genre:', array('class' => 'col-md-2')); }}
                {{ $errors->first('book_genre') }}
                <div class="col-md-4">
                    {{ Form::text('book_genre', '', array('class' => 'form-control', 'placeholder' => 'genre', 'required' => 'true')); }}
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
                      <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="book_image"></span>
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
 <script>
      $(function() {
        var availableTags = [
          "ActionScript",
          "AppleScript",
          "Asp",
          "BASIC",
          "C",
          "C++",
          "Clojure"
        ];
        $( "#author" ).autocomplete({
          source: availableTags
        });
      });
  </script>