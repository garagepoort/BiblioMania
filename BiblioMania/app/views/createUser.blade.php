@extends('main')

@section('content')
    <div class="row">
        <div class="page-header"><h2>Create User Form</h2></div>

        @if(Session::has('message'))
        <div class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

        {{ Form::open(array('url' => 'createUser', 'class' => 'form-horizontal')) }}
        <fieldset>

            <!-- Form Name -->
            <legend><h3>Register User</h3></legend>

            <!-- Text input-->
            <div class="form-group">
                {{ Form::label('usernameLabel', 'Username:', array('class' => 'col-md-1 control-label')) }}
                <div class="col-md-12">
                    {{ Form::text('username', '', array('class' => 'form-control input-md', 'placeholder' => 'Username', 'required' => 'true')); }}
                </div>
            </div>

            <!-- Email input -->
            <div class="form-group">
                {{ Form::label('emailLabel', 'Email:', array('class' => 'col-md-1 control-label')) }}
                <div class="col-md-12">
                    {{ Form::text('email', '', array('class' => 'form-control input-md', 'placeholder' => 'email', 'required' => 'true', 'type' => 'email')); }}
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                {{ Form::label('passwordLabel', 'Password:', array('class' => 'col-md-1 control-label')) }}
                <div class="col-md-12">
                    {{ Form::password('password', '', array('class' => 'form-control input-md', 'placeholder' => 'Password', 'required' => 'true')); }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('confirmPasswordLabel', 'Confirm Password:', array('class' => 'col-md-1 control-label')) }}
                <div class="col-md-12">
                    {{ Form::password('confirmPassword', '', array('class' => 'form-control input-md', 'placeholder' => 'Confirm Password', 'required' => 'true')); }}
                </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
                {{ Form::label('createLabel', 'Create user:', array('class' => 'col-md-1 control-label')) }}
                <div class="col-md-5">
                    {{ Form::submit('Create', array('class' => 'btn btn-block btn-success')) }}
                </div>
        </fieldset>
        {{ Form::close() }}
    </div> <!--./row -->
@stop