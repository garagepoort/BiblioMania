@extends('main')

@section('content')
<div class='author-container'>
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

	    <legend>Oeuvre</legend>
	    <table>
    		@foreach($author->oeuvre as $bookFromAuthor)
    			<tr>
    				<td>
						@if(count($bookFromAuthor->books) === 1)
							<a href="{{ URL::to('getBook', array('id' => $bookFromAuthor->books[0]->id)) }}">{{ $bookFromAuthor->title }}</a>
    					@else
    						{{ $bookFromAuthor->title }}
    					@endif
					</td>
    			</tr>
    		@endforeach
	    </table>
	</fieldset>
</div>
@stop