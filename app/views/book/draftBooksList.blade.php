@extends('main')

@section('title')
    Onvolledige boeken
@stop

@section('content')
    {{ HTML::script('assets/js/book/draftBooksList.js'); }}

    <div class="list-container table-responsive">
        <table id="bookEditList" class="table">
            <thead>
            <tr>
                <th>Titel</th>
                <th>Auteur</th>
                <th>Uitgever</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>
                        <p bookId="{{ $book->id }}">{{ $book->title }}</p>
                    </td>
                    <td>
                        @if($book->preferredAuthor() != null)
                        {{ $book->preferredAuthor()->name .', '. $book->preferredAuthor()->firstname }}
                        @endif
                    </td>
                    <td>
                        @if($book->preferredAuthor() != null)
                            {{ $book->publisher->name }}
                        @endif
                    </td>
                    <td style="text-align: center">
                            <span bookId="{{ $book->id }}" aria-hidden="true" style="margin-left:10px" class="fa fa-pencil editbook-goto" width="10px"/>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop