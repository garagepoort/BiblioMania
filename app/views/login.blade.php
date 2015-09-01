@extends('main')

@section('content')
<div class="loginPanel">
        <div class="page-header"><h2>Login</h2></div>
        @include('bendani/php-common/login-service::login-form')
</div>
@stop