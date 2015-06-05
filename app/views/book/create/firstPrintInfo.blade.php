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
                    {{ Form::select('book_languageId', $languages, $book_languageId, array('class' => 'input-sm form-control', 'id' => 'first_print_info_language')); }}
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

    </fieldset>
</div>