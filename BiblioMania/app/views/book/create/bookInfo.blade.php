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
                <div class="col-md-5">
                <input id="book_genre_input" type="text" name="book_genre" hidden>
                {{ Form::label('', '', array('id'=>'bookGenreLabel_input', 'class' => 'col-md-8')); }}
                </div>
            </div>
            <div class="well genres-container">
                <div class="form-group">
                    <div class="collapsible genres-header" class="col-md-2">Genres</div>
                    <div class="col-md-10">
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
 <script>
    $(function() {

        var substringMatcher = function(strs) {
          return function findMatches(q, cb) {
            var matches, substrRegex;
         
            // an array that will be populated with substring matches
            matches = [];
         
            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');
         
            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
              if (substrRegex.test(str)) {
                // the typeahead jQuery plugin expects suggestions to a
                // JavaScript object, refer to typeahead docs for more info
                matches.push({ value: str });
              }
            });
         
            cb(matches);
          };
        };
             
        var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
          'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
          'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
          'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
          'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
          'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
          'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
          'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
          'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
        ];

       $('#book_author').typeahead({
          hint: true,
          highlight: true,
          minLength: 1
        },
        {
          name: 'author',
          displayKey: 'value',
          source: substringMatcher(states)
        });
    });

    $(document).ready(function() {
    //collapsible management
        $('.collapsible').collapsible();

        $(".genre-listitem").hover(function(){
            if (!$(this).hasClass("clickedGenre")) {
                $(this).css("background-color","#611427");
                $(this).css("color","#DDDCC5");
            }
        },function(){
            if (!$(this).hasClass("clickedGenre")) {
                $(this).css("background-color","#DDDCC5");
                $(this).css("color","#611427");
            }
        });

        $(".genre-listitem").click(function(){
            $(".clickedGenre").css("background-color","#611427");
            $(".clickedGenre").css("color","#DDDCC5");
            $(".clickedGenre").removeClass("clickedGenre");
            $(this).addClass("clickedGenre");
            $("#bookGenreLabel_input").text($(this).attr("name"));
            $("#book_genre_input").val($(this).attr("genreId"));
        });
    });


  </script>