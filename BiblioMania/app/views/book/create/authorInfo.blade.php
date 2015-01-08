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
                @include('book/create/dateInputFragment', array('label' => 'Geboorte datum:',
                                       'dateDayName'=>'author_date_of_birth_day',
                                       'dateMonthName'=>'author_date_of_birth_month',
                                       'dateYearName'=>'author_date_of_birth_year'))
            </div>
        </div>

        <!-- DEATH DATE -->
        <div class="form-group">
            {{ Form::label('deathDateLabel', 'Sterfte datum:', array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                @include('book/create/dateInputFragment', array('label' => 'Sterfte datum:',
                                                    'dateDayName'=>'author_date_of_death_day',
                                                    'dateMonthName'=>'author_date_of_death_month',
                                                    'dateYearName'=>'author_date_of_death_year'))
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

        <div id='author-oeuvre-panel'>
            <input id="book-from-author-id-input" hidden name="bookFromAuthorTitle" />
            <legend>Oeuvre<span style="margin-left:10px" class="oeuvre-edit-icon fa fa-pencil-square-o"></span></legend>
            <ul id='author-oeuvre-list'>
            </ul>
            <div id='oeuvre-textarea-panel' style="display:none;">
                <textarea placeholder="<jaar> - <titel>" id='oeuvre-textarea' name="oeuvre" cols="80" rows="5"></textarea>
                <button class='btn btn-default' id='oeuvreButton'>Pas oeuvre aan</button>
            </div>
        </div>

    </fieldset>
</div>
{{ HTML::script('assets/js/createBook/authorInfo.js'); }}