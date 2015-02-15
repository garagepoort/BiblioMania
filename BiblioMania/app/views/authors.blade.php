@extends('main')

@section('title')
Auteurs
@stop
@section('content')
{{ HTML::script('assets/js/author/authors.js'); }}

<div class="authors-container">
	<table class="table authors-table" id="authors-container-table">
	    <tbody>
	    </tbody>
	</table>
    <div id="authors-loading-waypoint" style="text-align:center;">
        {{ HTML::image('images/ajax-loader.gif', 'loader', array('id'=>'loader-icon')) }}
		<p id="no-results-message" hidden>No results found.</p>
    </div>
</div>
@stop