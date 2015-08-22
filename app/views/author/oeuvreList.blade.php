<div class="material-card">
    <div class="material-card-title">Oeuvre</div>
    <div class="material-card-content">
        <table id="author-oeuvre-table" class="table">
            <thead>
            <tr>
                <th>Titel</th>
                <th>Publicatiejaar</th>
                <th>Verwijderen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($oeuvre as $bookFromAuthor)
                <tr>
                    <td>
                        <a
                                @if(count($bookFromAuthor->books)>0)
                                class="author-oeuvre-linked author-oeuvre-title"
                                @else
                                class="author-oeuvre-title"
                                @endif
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
                    <td oeuvre-id="{{ $bookFromAuthor->id }}" style="text-align: center">
                        @if(count($bookFromAuthor->books)==0)
                            <span aria-hidden="true" style="margin-left:10px"
                                  class="fa fa-times-circle oeuvre-author-cross" width="10px"/>
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>