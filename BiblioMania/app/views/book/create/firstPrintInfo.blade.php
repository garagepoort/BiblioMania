<div class="tab-container ">
    <fieldset>

    <legend>Eerste druk info</legend>

        @if(Session::has('message'))
        <div id="firstPrintInfoMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

         <!-- TITLE -->
            <div class="form-group">
                {{ Form::label('firstprint_titleLabel', 'Titel:', array('class' => 'col-md-2')); }}
                <div class="col-md-9">
                    {{ Form::text('first_print_title', '', array('id'=>'first_print_title', 'class' => 'form-control', 'placeholder' => 'titel', 'type' => 'text')); }}
                </div>
            </div>

            <!-- SUBTITLE -->
            <div class="form-group">
                {{ Form::label('first_print_subtitleLabel', 'Ondertitel:', array('class' => 'col-md-2 label-gray')); }}
                <div class="col-md-9">
                    {{ Form::text('first_print_subtitle', '', array('id'=>'first_print_subtitle', 'class' => 'form-control', 'placeholder' => 'ondertitel', 'type' => 'text')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- ISBN -->
                {{ Form::label('first_print_isbnLabel', 'ISBN:', array('class' => 'col-md-2')); }}
                <div class="col-md-3">
                    {{ Form::text('first_print_isbn', '', array('id'=>'first_print_isbn', 'class' => 'form-control', 'placeholder' => 'isbn', 'type' => 'number')); }}
                </div>
            </div>

           <div class="form-group">
                <!-- COUNTRY -->
                    {{ Form::label('first_print_CountryLabel', 'Land:', array('class' => 'col-md-2')); }}
                    <div class="col-md-5">
                        {{ Form::text('first_print_country', '', array('id'=>'first_print_country','class' => 'form-control typeahead', 'placeholder' => 'land', 'type' => 'text')); }}
                    </div>

                <!-- LANGUAGE -->
                {{ Form::label('first_print_LanguageLabel', 'Taal:', array('class' => 'col-md-1', 'style' => 'text-align: right')); }}
                <div class="col-md-3">
                    <select id="first_print_LanguageSelect" name="first_print_languageId" class="input-sm">
                        @foreach($languages as $language)
                        <option value="{{ $language->id }}">{{ $language->language }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <!-- PUBLISHER -->
                {{ Form::label('first_print_publisherLabel', 'Uitgever:', array('class' => 'col-md-2')); }}
                <div class="col-md-5">
                    {{ Form::text('first_print_publisher', '', array('id'=>'first_print_publisher','class' => 'form-control', 'placeholder' => 'publisher', 'type' => 'text')); }}
                </div>
            </div>

             <div class="form-group">
                <!-- PUBLICATION DATE -->
                {{ Form::label('firstPrintPublicationDateInfo', 'Publicatie:', array('class' => 'col-md-2')); }}
                <div class="col-md-7">
                    <table>
                        <tr>
                            <td>Dag:</td>
                            <td style='padding: 0 10px;'>{{ Form::text('first_print_publication_date_day', '', array('id'=>'first_print_publication_date_day', 'class' => 'form-control', 'style' => 'width: 80px', 'maxlength'=>'2')); }}</td>
                            <td>Maand:</td>
                            <td style='padding: 0 10px;'>{{ Form::text('first_print_publication_date_month', '', array('id'=>'first_print_publication_date_month', 'class' => 'form-control', 'style' => 'width: 80px', 'maxlength'=>'2')); }}</td>
                            <td>Jaar:</td>
                            <td style='padding: 0 10px;'>{{ Form::text('first_print_publication_date_year', '', array('id'=>'first_print_publication_date_year', 'class' => 'input-sm form-control', 'style' => 'width: 80px', 'maxlength'=>'4')); }}</td>
                        </tr>
                    </table>
                </div>

            </div>

            <!-- IMAGE -->
            <div class="form-group">
              {{ Form::label('first_print_imageBookLabel', 'Cover:', array('class' => 'col-md-2')); }}
                <!-- {{ $errors->first('book_image') }} -->
              <div class="col-md-4">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                    <div>
                      <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="first_print_image"></span>
                      <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                  </div>
              </div> 
            </div>

    </fieldset>
</div>