@extends('main')

@section('sidebar')
@stop

@section('content')
        <div class="row">
            <div class="page-header"><h2>{{ trans('messages.login.title') }}</h2></div>

            @if(Session::has('message'))
            <div id="loginAlertMessage" class="alert-danger alert">
                <strong>{{ Session::get('message') }}</strong>
            </div>
            @endif
            <legend><h3>{{ trans('messages.login.info') }}</h3></legend>
            {{ Form::open(array('url' => 'login', 'class' => 'form-horizontal')) }}
              <table id='loginTable'>
                  <tr>
                      <td>{{ Form::label('usernameLabel', trans('messages.login.label.user') , array('class' => 'control-label loginLabel')); }}</td>
                      <td>{{ Form::text('username', '', array('id' => 'usernameInputLogin','class' => 'form-control input-sm', 'placeholder' => trans('messages.login.placeholder.user'), 'required' => 'true')); }}</td>
                  </tr>
                  <tr>
                      <td>{{ Form::label('passwordLabel', trans('messages.login.label.password') , array('class' => 'control-label loginLabel')); }}</td>
                      <td>{{ Form::password('password', array('id' => 'passwordInputLogin','class' => 'form-control input-sm', 'placeholder' => trans('messages.login.placeholder.password'), 'required' => 'true')); }}</td>
                  </tr>
                  <tr>
                      <td>{{ Form::submit('Login', array('id' => 'loginButton','class' => 'btn btn-block btn-success')) }}</td>
                  </tr>

              </table>
            {{ Form::close() }}
        </div> <!--./row -->
@stop