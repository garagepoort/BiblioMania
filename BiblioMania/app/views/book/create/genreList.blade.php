<ul>
@foreach($genres as $genre)
    @if ( $genre->child_genres()->get()->isEmpty() )
    	<li class="genre-listitem" name="{{ $genre->name }}" genreId="{{ $genre->id }}">{{ $genre->name }} </li>
    @else
	    <li class="collapsible genre-listitem" name="{{ $genre->name }}" genreId="{{ $genre->id }}"> {{ $genre->name }}</li>
    	@include('book/create/genreList', array('genres' => $genre->child_genres()->get()))
    @endif
@endforeach
</ul>
