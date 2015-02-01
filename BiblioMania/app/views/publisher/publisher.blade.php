@extends('main')

@section('title')
    uitgever
@stop
@section('content')
    {{ HTML::script('assets/js/publisher/publisher.js'); }}

    <div class="info-container">
            <h1>{{ $publisher->name }}</h1>
        <fieldset>

            <legend>Boeken</legend>
            <ul>
                @foreach($publisher->books as $book)
                    <li>
                        {{ HTML::link('/getBooks?book_id='.$book->id, $book->title, array('id' => 'linkid'), false)}}
                    </li>
                @endforeach
            </ul>

            <legend>Eerste druks</legend>
            <ul>
                @foreach($publisher->first_print_infos as $first)
                    <li>{{ $first->title }}</li>
                @endforeach
            </ul>

            <legend>Landen</legend>
            <ul>
                @foreach($publisher->countries as $country)
                    <li>{{ $country->name }}</li>
                @endforeach
            </ul>
        </fieldset>
    </div>
@stop