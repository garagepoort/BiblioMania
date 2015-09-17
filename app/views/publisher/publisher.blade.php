\
@extends('main')

@section('title')
    {{ $publisher->name }}
@stop
@section('content')
    {{ HTML::script('assets/js/publisher/publisher.js'); }}

    <div class="info-container">
        <div class="material-card">
            <div class="material-card-title">Boeken</div>
            <div class="material-card-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Titel</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($publisher->books as $book)
                        <tr>
                            <td>
                                {{ HTML::link('/getBooks?book_id='.$book->id, $book->title, array('id' => 'linkid'), false)}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="material-card">
            <div class="material-card-title">Eerste druks</div>
            <div class="material-card-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Publicatiejaar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($publisher->first_print_infos as $first)
                        <tr>
                            <td>
                                {{ $first->title }}
                            </td>
                            <td>
                                {{ $first->publication_year }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="material-card">
            <div class="material-card-title">Landen</div>
            <div class="material-card-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Naam</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($countries as $country)
                        <tr>
                            <td>
                                {{ $country->name }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop