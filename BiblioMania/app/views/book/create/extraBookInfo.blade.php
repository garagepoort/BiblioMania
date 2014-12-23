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

        <legend>Cover info</legend>

            <!-- IMAGE -->
            <div class="form-group">
              {{ Form::label('imageBookLabel', 'Cover:', array('class' => 'col-md-3')); }}
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

    </fieldset>
</div>