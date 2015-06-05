<table class="table" hidden>
@foreach($genres as $genre)
    <tr>

        @if ( $genre->child_genres()->get()->isEmpty() )
            <td name="{{ $genre->name }}" genreId="{{ $genre->id }}">{{ $genre->name }} </td>
            <td>{{ Form::radio('genre', $genre); }}</td>
        @else
            <td name="{{ $genre->name }}" genreId="{{ $genre->id }}"> {{ $genre->name }}</td>
            <td>{{ Form::radio('genre', $genre); }}</td>
            @include('book.create.genre.genreTable', array('genres' => $genre->child_genres()->get()))
        @endif
    </tr>
@endforeach
</table>
