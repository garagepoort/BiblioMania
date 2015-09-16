<ul class="genre-list list-group">
@foreach($genres as $genre)
    @if ( $genre->child_genres()->get()->isEmpty() )
    	<li class="list-group-item genre-listitem clickable" name="{{ $genre->name }}" genreId="{{ $genre->id }}">{{ $genre->name }} </li>
    @else
	    <li class="list-group-item collapsible genre-listitem clickable" name="{{ $genre->name }}" genreId="{{ $genre->id }}"> {{ $genre->name }}</li>
    	<li class="list-group-item">
            @include('book.create.genre.genreList', array('genres' => $genre->child_genres()->get()))
        </li>
    @endif
@endforeach
</ul>
