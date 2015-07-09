@extends('main')

@section('title')
    Boeken
@stop

@section('content')
    {{ HTML::script('assets/js/book/bookSlidingPanel.js'); }}
    {{ HTML::script('assets/js/book/booksList.js'); }}

    <div class="list-container">
        <table id="bookEditList" class="table">
            <thead>
            <tr>
                <th>Titel</th>
                <th>Auteur</th>
                <th>Uitgever</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>
                        <p class="detailPanelTrigger" bookId="{{ $book->id }}">{{ $book->title }}</p>
                    </td>
                    <td>
                        {{ $book->preferredAuthor()->name .', '. $book->preferredAuthor()->firstname }}
                    </td>
                    <td>
                        {{ $book->publisher->name }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('book/bookSlidingPanel')
    </div>
@stop