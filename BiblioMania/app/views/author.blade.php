@extends('main')

@section('content')
    <div class='info-container'>
        <div id="messageBox"></div>
        <fieldset>
            <legend>{{ $author->firstname . ' ' . $author->infix . ' ' . $author->name }}</legend>
            <div class="author-image-div">
                {{ HTML::image($author->image, 'afbeelding niet gevonden',array('width'=>150)) }}
            </div>

            <table class="info-table">
                <tr>
                    <td>Geboortedatum:</td>
                    <td>{{ $author->date_of_birth }}</td>
                </tr>
                <tr>
                    <td>Stertedatum:</td>
                    <td>{{ $author->date_of_death }}</td>
                </tr>
            </table>

            <legend>Oeuvre</legend>
            <table id="author-oeuvre-table" class="table">
                <thead>
                <tr>
                    <th>Titel</th>
                    <th>Publicatiejaar</th>
                    <th>Verwijderen</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($author->oeuvre as $bookFromAuthor)
                        <tr>
                            <td>
                                <a class="author-oeuvre-title"
                                   data-name="name" href="#"
                                   data-type="text"
                                   data-pk="{{ $bookFromAuthor->id }}"
                                   data-url="{{ URL::to('updateBookFromAuthorTitle') }}"
                                   data-title="Vul naam in">{{ $bookFromAuthor->title }}</a>
                            </td>
                            <td>
                                <a class="author-oeuvre-title"
                                   data-name="year" href="#"
                                   data-type="text"
                                   data-pk="{{ $bookFromAuthor->id }}"
                                   data-url="{{ URL::to('updateBookFromAuthorPublicationYear') }}"
                                   data-title="Vul jaar in">{{ $bookFromAuthor->publication_year }}</a>
                            </td>
                            <td oeuvre-id={{ $bookFromAuthor->id }} style="text-align: center
                            "><span aria-hidden="true" style="margin-left:10px"
                                    class="fa fa-times-circle oeuvre-author-cross" width="10px"/></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </fieldset>
    </div>
    <script type="text/javascript">
        var author_json = {{ $author_json }};
    </script>
    {{ HTML::script('assets/js/author/author.js'); }}
@stop