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
                    {{ Form::text('infix', $infix,array('id' => 'infixInputLogin','class' => 'form-control input-sm', 'placeholder' => 'tussenvoegsel', 'required' => 'false')); }}
                </div>
            </div>

            <!-- Firstname input -->
            <div class="form-group">
                {{ Form::label('firstnameLabel', 'Voornaam:', array('class' => 'firstnameLabel col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('firstname', $firstname, array('id' => 'firstnameInputLogin','class' => 'form-control input-sm', 'placeholder' => 'password', 'required' => 'true')); }}
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
@stop