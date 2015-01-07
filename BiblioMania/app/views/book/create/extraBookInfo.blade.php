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
                {{ Form::label('authorLabel', "Pagina's:", array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('book_number_of_pages', '', array('id'=>'book_number_of_pages_input','class' => 'form-control input-sm', 'placeholder' => 'paginas', 'type' => 'number')); }}
                </div>
            </div>
            <div class="form-group">
                <!-- PRINT -->
                {{ Form::label('printLabel', 'Print:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('book_print', '', array('id'=>'book_print_input', 'class' => 'form-control input-sm', 'placeholder' => 'print', 'type' => 'number')); }}
                </div>
            </div>
        </div>

        <legend>Serie</legend>
        <div class="form-group">
            <!-- Book serie -->
            {{ Form::label('bookSerieLabel', "Boekenreeks:", array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                {{ Form::text('book_serie', '', array('id'=>'book_serie_input','class' => 'form-control input-sm', 'placeholder' => '')); }}
            </div>
        </div>

        <div class="form-group">
            <!-- PUBLISHER SERIE -->
            {{ Form::label('publisherSerieLabel', 'Uitgeverreeks:', array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                {{ Form::text('book_publisher_serie', '', array('id'=>'publisher_serie_input', 'class' => 'form-control input-sm', 'placeholder' => '')); }}
            </div>
        </div>

    </fieldset>
</div>