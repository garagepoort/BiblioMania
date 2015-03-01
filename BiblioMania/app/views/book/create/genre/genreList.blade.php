<ul class="genre-list">
@foreach($genres as $genre)
    @if ( $genre->child_genres()->get()->isEmpty() )
    	<li class="genre-listitem clickable" name="{{ $genre->name }}" genreId="{{ $genre->id }}">{{ $genre->name }} </li>
    @else
	    <li class="collapsible genre-listitem clickable" name="{{ $genre->name }}" genreId="{{ $genre->id }}"> {{ $genre->name }}</li>
    	@include('book.create.genre.genreList', array('genres' => $genre->child_genres()->get()))
    @endif
@endforeach
</ul>
