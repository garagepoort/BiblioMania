@extends('main')

@section('title')
Auteurs
@stop
@section('content')
<script type="text/javascript">
    var baseUrl = "{{ URL::to('/') }}";
</script>
{{ HTML::script('assets/js/author/authors.js'); }}

<div class="authors-container">
	<table class="table authors-table" id="authors-container-table">
	    <tbody class="infinite-container">
	    </tbody>
	</table>
    <div id="authors-loading-waypoint" style="text-align:center;">
        {{ HTML::image('images/ajax-loader.gif', 'loader', array('id'=>'loader-icon')) }}
    </div>
</div>
@stop