@extends('main')
@section("title")
    {{ $title }}
@endsection
@section("content")
    <div class="wizard-steps">
        @include('book/wizard/wizardsteps', array('wizardSteps' => $wizardSteps, 'currentStep' => '3'))
    </div>
    <div class="create-book-div">
        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => 'createOrEditBook/step3/' . $book_id, 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
        <input id="redirectInput" hidden name="redirect" value="NEXT">

        <div id="error-div" class="material-card error-message" hidden>
            <div id="error-message" class="material-card-content error-message"></div>
        </div>

        <fieldset>
            <legend>Auteur info</legend>
            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div id="bookInfoMessage" class="alert-danger alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
            @endif

            <div class="form-container">

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


                @include('image/uploadImage', array(
                'checkbox' => 'authorImageSelfUpload',
                'imageUrlInput' => 'authorImageUrl',
                'contentDivId' => 'authorImageContent',
                'file' =>'author_image'))


                <div id='author-oeuvre-panel'>
                    <input id="book-from-author-id-input" hidden name="bookFromAuthorTitle" value="{{ $book_from_author_title }}"/>
                    <legend>Oeuvre<span style="margin-left:10px"
                                        class="oeuvre-edit-icon fa fa-pencil-square-o"></span>
                    </legend>
                    <ul id='author-oeuvre-list'>
                    </ul>
                    <div id='oeuvre-textarea-panel' style="display:none;">
                    <textarea placeholder="<jaar> - <titel>" id='oeuvre-textarea' name="oeuvre" cols="80"
                              rows="5"></textarea>
                        <button class='btn btn-default' id='oeuvreButton'>Pas oeuvre aan</button>
                    </div>
                </div>

                @include('book/wizard/submitButtons')
            </div>

        </fieldset>
        {{ Form::close(); }}
    </div>

    <script type="text/javascript">
        var authors_json = {{ $authors_json }};
        var author_names = [];
        $.each(authors_json, function (index, obj) {
            if (obj.infix != '') {
                author_names[author_names.length] = obj.name + ', ' + obj.infix + ', ' + obj.firstname;
            } else {
                author_names[author_names.length] = obj.name + ', ' + obj.firstname;
            }
        });
    </script>
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
    {{ HTML::script('assets/js/book/GoogleBookSearch.js'); }}
    {{ HTML::script('assets/js/book/wizard/author.js'); }}
@endsection
@stop