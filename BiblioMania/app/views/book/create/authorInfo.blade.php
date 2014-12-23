<div class="tab-container ">
    <fieldset>

    <legend>Auteur info</legend>


        @if(Session::has('message'))
        <div id="authorInfoMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif
        
        <!-- NAME -->
        <div class="form-group">
            {{ Form::label('authorNameLabel', 'Naam voornaam:', array('class' => 'col-md-3')); }}
            <div class="col-md-4">
                {{ Form::text('author_name', '', array('id'=>'author_name','class' => 'form-control', 'placeholder' => 'naam', 'required' => 'true')); }}
            </div>
            <div class="col-md-4">
                {{ Form::text('author_firstname', '', array('id'=>'author_firstname','class' => 'form-control', 'placeholder' => 'voornaam', 'required' => 'true')); }}
            </div>
        </div>

        <!-- BIRTH DATE -->
        <div class="form-group">
            {{ Form::label('birthDateLabel', 'Geboorte datum:', array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                {{ Form::text('author_date_of_birth', '', array('id'=>'author_date_of_birth', 'class' => 'input-sm datepicker', 'placeholder' => 'select date', 'data-format' => 'dd-MM-yyyy')); }}
            </div>
        </div>
        
        <!-- DEATH DATE -->
        <div class="form-group">
            {{ Form::label('deathDateLabel', 'Sterfte datum:', array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                {{ Form::text('author_date_of_death', '', array('id'=>'author_date_of_death', 'class' => 'input-sm datepicker', 'placeholder' => 'select date', 'data-format' => 'dd-MM-yyyy')); }}
            </div>
        </div>

         <!-- BOOK FROM AUTHOR -->
        <div class="form-group">
            {{ Form::label('bookFromAuthorLabel', 'Oeuvre:', array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                {{ Form::text('author_book_from_author', '', array('id'=>'author_book_from_author', 'class' => 'input-sm', 'placeholder' => 'book')); }}
            </div>
        </div>

        <!-- IMAGE -->
        <div class="form-group">
          {{ Form::label('imageAuthorLabel', 'Afbeelding:', array('class' => 'col-md-3')); }}
          <div class="col-md-3">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                <div>
                  <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="..."></span>
                  <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
              </div>
          </div>
        </div>

    </fieldset>
</div>
 <script>
      
  </script>