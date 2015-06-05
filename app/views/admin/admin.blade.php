@extends('main')

@section('title')
    Admin
@stop

@section('content')
    <div class='info-container'>
        <fieldset>
            <legend>Database backup</legend>
            <p>Backs up database to google drive.</p>
            <button id="backupDatabaseButton" class="btn btn-primary clickableRow" style="margin-bottom: 40px" href=" {{ URL::to('backupDatabase') }}">Backup database</button>
        </fieldset>
    </div>
@stop
