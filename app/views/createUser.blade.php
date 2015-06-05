@extends('main')

@section('content')
<div class="createUserPanel">
        <div class="page-header"><h2>Maak je eigen account</h2></div>

        @if(Session::has('message'))
        <div class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

        {{ Form::open(array('url' => 'createUser', 'class' => 'form-horizontal')) }}
        <fieldset>

            <!-- Username input -->
            <div class="form-group">
                {{ Form::label('usernameLabel', 'Username:', array('class' => 'col-md-3 control-label')) }}
                <div class="col-md-5">
                    {{ Form::text('username', '', array('class' => 'form-control input-sm', 'placeholder' => 'username', 'required' => 'true')); }}
                </div>
            </div>

            <!-- Email input -->
            <div class="form-group">
                {{ Form::label('emailLabel', 'Email:', array('class' => 'col-md-3 control-label')) }}
                <div class="col-md-5">
                    {{ Form::text('email', '', array('class' => 'form-control input-sm', 'placeholder' => 'email', 'required' => 'true', 'type' => 'email')); }}
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                {{ Form::label('passwordLabel', 'Password:', array('class' => 'col-md-3 control-label')) }}
                <div class="col-md-3">
                    {{ Form::password('password', array('class' => 'form-control input-sm passwordInput', 'placeholder' => 'Password', 'required' => 'true')); }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('confirmPasswordLabel', 'Confirm Password:', array('class' => 'col-md-3 control-label')) }}
                <div class="col-md-3">
                    {{ Form::password('confirmPassword', array('class' => 'form-control input-sm passwordInput', 'placeholder' => 'Confirm Password', 'required' => 'true')); }}
                </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-5">
                    {{ Form::submit('Create', array('class' => 'btn btn-block btn-success')) }}
                </div>
            </div>
        </fieldset>
        {{ Form::close() }}
</div>
@stop