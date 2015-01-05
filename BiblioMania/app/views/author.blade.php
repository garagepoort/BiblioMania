@extends('main')

@section('content')
<div class='author-container'>
    <div id="messageBox"></div>
	<fieldset>
		<legend>{{ $author->firstname . ' ' . $author->infix . ' ' . $author->name }}</legend>
        <div class="author-image-div">
        	{{ HTML::image($author->image, 'afbeelding niet gevonden',array('width'=>150)) }}
    	</div>

    	<table class="info-table">
    		<tr>
    			<td>Geboortedatum:</td>
    			<td>{{ $author->date_of_birth }}</td>
    		</tr>
    		<tr>
    			<td>Stertedatum:</td>
    			<td>{{ $author->date_of_death }}</td>
    		</tr>
    	</table>

	    <legend>Oeuvre<span id="oeuvre-author-edit-all-icon" aria-hidden="true" style="margin-left:10px" class="glyphicon glyphicon-pencil oeuvre-author-pencil" width="10px"></span></legend>
	    <table>
    		@foreach($author->oeuvre as $bookFromAuthor)
    			<tr>
    				<td oeuvre-id={{ $bookFromAuthor->id }}>
						@if(count($bookFromAuthor->books) > 0)
							<span class="author-oeuvre-link"><a class="author-oeuvre-title" href="{{ URL::to('getBooks?book_id='.$bookFromAuthor->books[0]->id) }}">{{ $bookFromAuthor->title }}</a></span>
    					@else
    						<span class="author-oeuvre-link"><span class="author-oeuvre-title">{{ $bookFromAuthor->title }}</span></span>
    					@endif
					</td>
    			</tr>
    		@endforeach
	    </table>
	</fieldset>
</div>
<script type="text/javascript">
    var author_json = {{ $author_json }};
    var baseUrl = "{{ URL::to('/') }}";
</script>
{{ HTML::script('assets/js/author/author.js'); }}
@stop