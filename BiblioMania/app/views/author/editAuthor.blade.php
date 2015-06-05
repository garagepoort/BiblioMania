@extends('main')
@section('title')
    <span>{{ $title }}</span>
@stop
@section('content')
    <div class='info-container'>
        @if(Session::has('message'))
            <div id="loginAlertMessage" class="alert-danger alert">
                <strong>{{ Session::get('message') }}</strong>
            </div>
        @endif

        {{ Form::open(array('url' => 'editAuthor', 'class' => 'form-horizontal')) }}
        <input id="author-id-input" name="author_id" hidden value={{ $author_id }}>
        <fieldset>
            <div class="form-group">
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                    @if($image != '')
                        {{ HTML::image($image, 'image') }}
                    @endif
                </div>
            </div>

            <!-- IMAGE -->
            <span style="margin-right: 10px">Ik wil zelf een afbeelding uploaden:</span><input id="author-image-self-upload-checkbox" type="checkbox" name="imageSelfUpload"/>

            <div id="author-image-self-upload-panel" class="form-group" hidden>
                {{ Form::label('imageAuthorLabel', 'Afbeelding:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                        <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>{{ Form::file('image') }}</span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="author-image-google-search-panel">
                @include('googleImageSearch', array('imageUrlInput' => 'imageUrl','contentDivId' => 'authorImageContent'))
            </div>

            <!-- Name input-->
            <div class="form-group">
                {{ Form::label('nameLabel', 'Naam:' , array('class' => 'nameLabel col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('name', $name , array('id' => 'nameInput','class' => 'form-control input-sm', 'placeholder' => 'naam', 'required' => 'true')); }}
                </div>
            </div>

            <!-- Infix input -->
            <div class="form-group">
                {{ Form::label('infixLabel', 'Tussenvoegsel:', array('class' => 'infixLabel col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('infix', $infix,array('id' => 'infixInput','class' => 'form-control input-sm', 'placeholder' => 'tussenvoegsel', 'required' => 'false')); }}
                </div>
            </div>

            <!-- Firstname input -->
            <div class="form-group">
                {{ Form::label('firstnameLabel', 'Voornaam:', array('class' => 'firstnameLabel col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('firstname', $firstname, array('id' => 'firstnameInput','class' => 'form-control input-sm', 'placeholder' => 'password', 'required' => 'true')); }}
                </div>
            </div>

            <!-- BIRTH DATE -->
            <div class="form-group">
                {{ Form::label('birthDateLabel', 'Geboorte datum:', array('class' => 'col-md-3 label-gray')); }}
                <div class="col-md-3">
                    @include('book/create/dateInputFragment', array('label' => 'Geboorte datum:',
                                           'dateDayName'=>'date_of_birth_day',
                                           'dateMonthName'=>'date_of_birth_month',
                                           'dateYearName'=>'date_of_birth_year',
                                            'dateDayValue' => $date_of_birth_day,
                                            'dateMonthValue' => $date_of_birth_month,
                                            'dateYearValue' => $date_of_birth_year))
                </div>
            </div>

            <!-- DEATH DATE -->
            <div class="form-group">
                {{ Form::label('deathDateLabel', 'Sterfte datum:', array('class' => 'col-md-3 label-gray')); }}
                <div class="col-md-3">
                    @include('book/create/dateInputFragment', array('label' => 'Sterfte datum:',
                                                        'dateDayName'=>'date_of_death_day',
                                                        'dateMonthName'=>'date_of_death_month',
                                                        'dateYearName'=>'date_of_death_year',
                                                        'dateDayValue' => $date_of_death_day,
                                                        'dateMonthValue' => $date_of_death_month,
                                                        'dateYearValue' => $date_of_death_year))
                </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
                <div class="col-md-3">
                    {{ Form::submit('Wijzig', array('id' => 'editAuthorButton','class' => 'btn btn-block btn-primary editAuthorButton')) }}
                </div>
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>
    {{ HTML::script('assets/js/author/editAuthor.js'); }}
@stop
