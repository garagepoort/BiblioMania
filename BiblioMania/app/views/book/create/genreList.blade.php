<ul>
@foreach($genres as $genre)
    @if ( $genre->child_genres()->get()->isEmpty() )
    	<li class="genre-listitem" name="{{ $genre->name }}" genreId="{{ $genre->id }}">{{ $genre->name }} <span class="glyphicon glyphicon-plus"></span></li>
    @else
	    <li class="collapsible genre-listitem" name="{{ $genre->name }}" genreId="{{ $genre->id }}"> {{ $genre->name }} <span class="glyphicon glyphicon-plus"></span></li>
    	@include('book/create/genreList', array('genres' => $genre->child_genres()->get()))
    @endif
@endforeach
</ul>
