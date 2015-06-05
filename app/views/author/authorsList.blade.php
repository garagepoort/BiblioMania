@extends('main')

@section('title')
    Auteurs
@stop

@section('content')
    {{ HTML::script('assets/js/author/authorsList.js'); }}

    <div class="list-container">
        <table id="authorEditList" class="table">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Voornaam</th>
                <th>tussenvoegsel</th>
                <th>Geboortedatum</th>
                <th>SterfteDatum</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>
                        <a id="name" data-name="name" href="#" data-type="text" data-pk={{ $author->id }} data-url={{ URL::to('editAuthorInList') }} data-title="Vul naam in">{{ $author->name }}</a>
                    </td>
                    <td>
                        <a id="firstname" data-name="firstname" href="#" data-type="text" data-pk={{ $author->id }} data-url={{ URL::to('editAuthorInList') }} data-title="Vul voornaam in">{{ $author->firstname }}</a>
                    </td>
                    <td>
                        <a id="infix" data-name="infix" href="#" data-type="text" data-pk={{ $author->id }} data-url={{ URL::to('editAuthorInList') }} data-title="Vul infix in">{{ $author->infix }}</a>
                    </td>
                    <td>
                        <a id="date_of_birth" data-name="date_of_birth" href="#" data-type="text" data-pk={{ $author->id }} data-url={{ URL::to('editAuthorInList') }} data-title="Vul geboorte in (dd-mm-yyyy)">{{ App::make('DateService')->createStringFromDate($author->date_of_birth) }}</a>
                    </td>
                    <td>
                        <a id="date_of_death" data-name="date_of_death" href="#" data-type="text" data-pk={{ $author->id }} data-url={{ URL::to('editAuthorInList') }} data-title="Vul sterfte in (dd-mm-yyyy)">{{ App::make('DateService')->createStringFromDate($author->date_of_death) }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop