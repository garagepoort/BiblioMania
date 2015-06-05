@extends('main')

@section('content')
<div class="loginPanel">
        <div class="page-header"><h2>Login</h2></div>

        @if(Session::has('message'))
        <div id="loginAlertMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

        {{ Form::open(array('url' => 'login', 'class' => 'form-horizontal')) }}

        <fieldset>

            <!-- email input-->
            <div class="form-group">
                {{ Form::label('usernameLabel', 'Username:' , array('class' => 'control-label loginLabel col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::text('username', '', array('id' => 'usernameInputLogin','class' => 'form-control input-sm', 'placeholder' => 'username', 'required' => 'true')); }}
                </div>
            </div>

            <!-- password input -->
            <div class="form-group">
                {{ Form::label('passwordLabel', 'Paswoord:', array('class' => 'control-label loginLabel col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::password('password', array('id' => 'passwordInputLogin','class' => 'form-control input-sm', 'placeholder' => 'password', 'required' => 'true')); }}
                </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    {{ Form::submit('Login', array('id' => 'loginButton','class' => 'btn btn-block btn-success loginButton')) }}
                </div>
            </div>
        </fieldset>
        {{ Form::close() }}
</div>
@stop