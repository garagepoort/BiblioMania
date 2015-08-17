@extends('main')
@section("title")
    {{ $title }}
@endsection
@section("content")
    <div class="wizard-steps">
        @include('book/wizard/wizardsteps', array('wizardSteps' => $wizardSteps, 'currentStep' => '2', 'progress' => $book_wizard_step))
    </div>
    <div class="create-book-div">
        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => 'createOrEditBook/step/2/' . $book_id, 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}

        <fieldset>
            <input id="redirectInput" hidden name="redirect" value="NEXT">
            <legend>Boek extras</legend>
            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div id="bookInfoMessage" class="alert-danger alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
            @endif

            <div class="form-container">
                <!-- COVER PRICE -->
                <div class="form-group">
                    {{ Form::label('book_info_retail_price_label', 'Cover prijs:', array('class' => 'col-md-3 control-label')); }}
                    <div class="col-md-2">
                        {{ Form::select('book_info_retail_price_currency', $currencies, $book_info_retail_price_currency, array('class' => 'input-sm form-control')); }}
                    </div>
                    <div class="col-md-3">
                        {{ Form::text('book_info_retail_price', $book_info_retail_price, array('id'=>'book_info_retail_price','class' => 'form-control input-sm', 'placeholder' => 'prijs', 'type' => 'number')); }}
                    </div>
                </div>

                <div class="form-group">
                    <!-- PAGES -->
                    {{ Form::label('authorLabel', "Pagina's:", array('class' => 'col-md-3 label-gray control-label')); }}
                    <div class="col-md-3">
                        {{ Form::text('book_number_of_pages', $book_number_of_pages, array('id'=>'book_number_of_pages_input','class' => 'form-control input-sm', 'placeholder' => 'paginas', 'type' => 'number')); }}
                    </div>
                </div>
                <div class="form-group">
                    <!-- PRINT -->
                    {{ Form::label('printLabel', 'Print:', array('class' => 'col-md-3 label-gray control-label')); }}
                    <div class="col-md-3">
                        {{ Form::text('book_print', $book_print, array('id'=>'book_print_input', 'class' => 'form-control input-sm', 'placeholder' => 'print', 'type' => 'number')); }}
                    </div>
                </div>
                <div class="form-group">
                    <!-- TRANSLATOR -->
                    {{ Form::label('translatorLabel', 'Vertaler:', array('class' => 'col-md-3 label-gray control-label')); }}
                    <div class="col-md-3">
                        {{ Form::text('translator', $translator, array('id'=>'translator_input', 'class' => 'form-control input-sm', 'placeholder' => 'vertaler')); }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('bookStateLabel', 'Conditie:', array('class' => 'col-md-3 control-label')); }}
                    <div class="col-md-4">
                        {{ Form::select('book_state', $states, $book_state, array('class' => 'input-sm form-control')); }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('summary_label', 'Samenvatting:', array('class' => 'col-md-3 control-label')); }}
                    <div class="col-md-3">
                        {{ Form::textarea('book_summary', $book_summary, array('id' => 'book_summary_input')) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('old_tags_label', 'Tags:', array('class' => 'col-md-3 control-label')); }}
                    <div class="col-md-3">
                        {{ Form::textarea('book_old_tags', $book_old_tags, array('id' => 'book_old_tags')) }}
                    </div>
                </div>
            </div>

            <legend>Serie</legend>
            <div class="form-group">
                <!-- Book serie -->
                {{ Form::label('bookSerieLabel', "Boekenreeks:", array('class' => 'col-md-3 label-gray control-label')); }}
                <div class="col-md-3">
                    {{ Form::text('book_serie', $book_serie, array('id'=>'book_serie_input','class' => 'form-control input-sm', 'placeholder' => '')); }}
                </div>
            </div>

            <div class="form-group">
                <!-- PUBLISHER SERIE -->
                {{ Form::label('publisherSerieLabel', 'Uitgeverreeks:', array('class' => 'col-md-3 label-gray control-label')); }}
                <div class="col-md-3">
                    {{ Form::text('book_publisher_serie', $book_publisher_serie, array('id'=>'publisher_serie_input', 'class' => 'form-control input-sm', 'placeholder' => '')); }}
                </div>
            </div>

            @include('book/wizard/submitButtons')
        </fieldset>
        {{ Form::close(); }}
    </div>
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
    {{ HTML::script('assets/js/book/wizard/bookExtra.js'); }}
@endsection
@stop