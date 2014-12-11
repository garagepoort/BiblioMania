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
            {{ Form::label('authorNameLabel', 'Naam:', array('class' => 'col-md-3')); }}
            {{ $errors->first('author') }}
            <div class="col-md-8">
                {{ Form::text('author_name', '', array('id'=>'author_name','class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'true')); }}
            </div>
        </div>

        <!-- BIRTH DATE -->
        <div class="form-group">
            {{ Form::label('birthDateLabel', 'Geboorte datum:', array('class' => 'col-md-3')); }}
            {{ $errors->first('date_of_birth') }}
            <div class="col-md-3">
                {{ Form::text('date_of_birth', '', array('class' => 'input-sm datepicker', 'placeholder' => 'select date', 'data-format' => 'dd-MM-yyyy')); }}
            </div>
        </div>
        
        <!-- DEATH DATE -->
        <div class="form-group">
            {{ Form::label('deathDateLabel', 'Sterfte datum:', array('class' => 'col-md-3')); }}
            {{ $errors->first('date_of_death') }}
            <div class="col-md-3">
                {{ Form::text('date_of_death', '', array('class' => 'input-sm datepicker', 'placeholder' => 'select date', 'data-format' => 'dd-MM-yyyy')); }}
            </div>
        </div>

        <!-- IMAGE -->
        <div class="form-group">
          {{ Form::label('imageAuthorLabel', 'Afbeelding:', array('class' => 'col-md-3')); }}
            {{ $errors->first('authorImage') }}
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
      $(function() {
        var availableTags = [
          "ActionScript",
          "AppleScript",
          "Asp",
          "BASIC"
        ];
        $( "#author" ).autocomplete({
          source: availableTags
        });
      });
  </script>