<div class="tab-container ">

    <fieldset>

        <legend>Auteur info</legend>
        @if($author_image != '')
            {{ HTML::image($author_image, 'image', array('style' => 'margin-bottom: 10px;')) }}
        @endif
                    <!-- NAME -->
            <div class="form-group">
                {{ Form::label('authorNameLabel', 'Naam:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('author_firstname', $author_firstname, array('id'=>'author_firstname','class' => 'form-control', 'placeholder' => 'voornaam', 'required' => 'true')); }}
                </div>
                <div class="col-md-2">
                    {{ Form::text('author_infix', $author_infix, array('id'=>'author_infix','class' => 'form-control', 'placeholder' => '')); }}
                </div>
                <div class="col-md-3">
                    {{ Form::text('author_name', $author_name, array('id'=>'author_name','class' => 'form-control', 'placeholder' => 'naam', 'required' => 'true')); }}
                </div>
            </div>

            <!-- Tags -->
            <div class="form-group">
                {{ Form::label('secondaryAuthorsLabel', 'Extra auteurs:', array('class' => 'col-md-3')); }}
                <div class="col-md-8">
                    {{ Form::text('secondary_authors', $secondary_authors, array('id'=>'secondary_authors_input', 'class' => 'form-control', 'type' => 'text')); }}
                </div>
            </div>

            <!-- BIRTH DATE -->
            <div class="form-group">
                {{ Form::label('birthDateLabel', 'Geboorte datum:', array('class' => 'col-md-3 label-gray')); }}
                <div class="col-md-3">
                    @include('book/create/dateInputFragment', array('label' => 'Geboorte datum:',
                                           'dateDayName'=>'author_date_of_birth_day',
                                           'dateMonthName'=>'author_date_of_birth_month',
                                           'dateYearName'=>'author_date_of_birth_year',
                                            'dateDayValue' => $author_date_of_birth_day,
                                            'dateMonthValue' => $author_date_of_birth_month,
                                            'dateYearValue' => $author_date_of_birth_year))
                </div>
            </div>

            <!-- DEATH DATE -->
            <div class="form-group">
                {{ Form::label('deathDateLabel', 'Sterfte datum:', array('class' => 'col-md-3 label-gray')); }}
                <div class="col-md-3">
                    @include('book/create/dateInputFragment', array('label' => 'Sterfte datum:',
                                                        'dateDayName'=>'author_date_of_death_day',
                                                        'dateMonthName'=>'author_date_of_death_month',
                                                        'dateYearName'=>'author_date_of_death_year',
                                                        'dateDayValue' => $author_date_of_death_day,
                                                        'dateMonthValue' => $author_date_of_death_month,
                                                        'dateYearValue' => $author_date_of_death_year))
                </div>
            </div>

            <!-- IMAGE -->
            <span style="margin-right: 10px">Ik wil zelf een afbeelding uploaden:</span><input
                    id="author-image-self-upload-checkbox" type="checkbox" name="authorImageSelfUpload"/>

            <div id="author-image-self-upload-panel" class="form-group" hidden>
                {{ Form::label('imageAuthorLabel', 'Afbeelding:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                             style="width: 200px; height: 150px;"></div>
                        <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span
                                        class="fileinput-exists">Change</span>{{ Form::file('author_image') }}</span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="author-image-google-search-panel">
                @include('googleImageSearch', array('imageUrlInput' => 'authorImageUrl','contentDivId' => 'authorImageContent'))
            </div>


            <div id='author-oeuvre-panel'>
                <input id="book-from-author-id-input" hidden name="bookFromAuthorTitle"
                       value="{{ $book_from_author_title }}"/>
                <legend>Oeuvre<span style="margin-left:10px" class="oeuvre-edit-icon fa fa-pencil-square-o"></span>
                </legend>
                <ul id='author-oeuvre-list'>
                </ul>
                <div id='oeuvre-textarea-panel' style="display:none;">
                    <textarea placeholder="<jaar> - <titel>" id='oeuvre-textarea' name="oeuvre" cols="80"
                              rows="5"></textarea>
                    <button class='btn btn-default' id='oeuvreButton'>Pas oeuvre aan</button>
                </div>
            </div>

    </fieldset>
</div>
{{ HTML::script('assets/js/createBook/authorInfo.js'); }}