<div class="tab-container ">
    <fieldset>

    <legend>Extra boek info</legend>
        @if ($errors->has())
            @foreach ($errors->all() as $error)  
                <div id="extraBookInfoMessage" class="alert-danger alert">
                    <strong>{{ $error }}</strong>
                </div>       
            @endforeach
        @endif

        <div class="form-container">

            <div class="form-group">
                <!-- PAGES -->
                {{ Form::label('authorLabel', "Pagina's:", array('class' => 'col-md-3 label-gray')); }}
                <div class="col-md-3">
                    {{ Form::text('book_number_of_pages', $book_number_of_pages, array('id'=>'book_number_of_pages_input','class' => 'form-control input-sm', 'placeholder' => 'paginas', 'type' => 'number')); }}
                </div>
            </div>
            <div class="form-group">
                <!-- PRINT -->
                {{ Form::label('printLabel', 'Print:', array('class' => 'col-md-3 label-gray')); }}
                <div class="col-md-3">
                    {{ Form::text('book_print', $book_print, array('id'=>'book_print_input', 'class' => 'form-control input-sm', 'placeholder' => 'print', 'type' => 'number')); }}
                </div>
            </div>
            <div class="form-group">
                <!-- TRANSLATOR -->
                {{ Form::label('translatorLabel', 'Vertaler:', array('class' => 'col-md-3 label-gray')); }}
                <div class="col-md-3">
                    {{ Form::text('translator', $translator, array('id'=>'translator_input', 'class' => 'form-control input-sm', 'placeholder' => 'vertaler')); }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('bookStateLabel', 'Conditie:', array('class' => 'col-md-3')); }}
                <div class="col-md-4">
                    {{ Form::select('book_state', $states, $book_state, array('class' => 'input-sm form-control')); }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('summary_label', 'Samenvatting:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::textarea('book_summary', $book_summary, array('id' => 'book_summary_input')) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('old_tags_label', 'Tags:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::textarea('book_old_tags', $book_old_tags, array('id' => 'book_old_tags')) }}
                </div>
            </div>
        </div>

        <legend>Serie</legend>
        <div class="form-group">
            <!-- Book serie -->
            {{ Form::label('bookSerieLabel', "Boekenreeks:", array('class' => 'col-md-3 label-gray')); }}
            <div class="col-md-3">
                {{ Form::text('book_serie', $book_serie, array('id'=>'book_serie_input','class' => 'form-control input-sm', 'placeholder' => '')); }}
            </div>
        </div>

        <div class="form-group">
            <!-- PUBLISHER SERIE -->
            {{ Form::label('publisherSerieLabel', 'Uitgeverreeks:', array('class' => 'col-md-3 label-gray')); }}
            <div class="col-md-3">
                {{ Form::text('book_publisher_serie', $book_publisher_serie, array('id'=>'publisher_serie_input', 'class' => 'form-control input-sm', 'placeholder' => '')); }}
            </div>
        </div>

    </fieldset>
</div>

<script type="text/javascript">
    var series_json = {{ $series_json }};
    var publisher_series_json = {{ $publisher_series_json }};
    var serie_titles = [];
    var publisher_serie_titles = [];
    $.each(series_json, function (index, obj) {
        serie_titles[serie_titles.length] = obj.name;
    });
    $.each(publisher_series_json, function (index, obj) {
        publisher_serie_titles[publisher_serie_titles.length] = obj.name;
    });
</script>
{{ HTML::script('assets/js/createBook/extraBookInfo.js'); }}