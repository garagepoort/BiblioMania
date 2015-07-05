@extends('main')

@section('title')
    {{ $author->firstname . ' ' . $author->infix . ' ' . $author->name }}
@stop

@section('content')
    <div class='info-container'>
        <div id="messageBox"></div>
        <fieldset>
            <div class="material-card author-image-div" style="float: left;">
                <div class="material-card-content" id="author-image-div">
                    <div class="author-image-edit-wrapper" id="author-image-edit-wrapper">
                        <span class="helper"></span>
                        {{ HTML::image('images/edit_icon.png', 'edit icon',array('class'=>'author-image-edit-icon')) }}
                    </div>
                </div>
            </div>

            <div class="material-card" style="float: left;">
                <div class="material-card-title">Info</div>
                <div class="material-card-content">
                    <table class="info-table">
                        <tr>
                            <td>Geboortedatum:</td>
                            <td>
                                @if($author->date_of_birth != null)
                                    {{ $author->date_of_birth->day . ' ' . $author->date_of_birth->month . ' ' . $author->date_of_birth->year }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Stertedatum:</td>
                            <td>
                                @if($author->date_of_death != null)
                                    {{ $author->date_of_death->day . ' ' . $author->date_of_death->month . ' ' . $author->date_of_death->year }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="author-image-upload-div material-card" id="author-image-upload-div" hidden="hidden">
                <div class="material-card-title">Afbeelding uploaden</div>
                <div class="material-card-content">
                    {{ Form::open(array('id'=>'changeAuthorImageForm', 'url' => 'changeAuthorImage', 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
                    <input id="author-id-input" name="author_id" hidden value={{ $author->id }}>
                    @include('image/uploadImage', array(
                    'checkbox' => 'authorImageSelfUpload',
                    'imageUrlInput' => 'authorImageUrl',
                    'contentDivId' => 'authorImageContent',
                    'file' =>'author_image'))
                    <div class="controls">
                        {{ Form::submit('Afbeelding opslaan', array('id'=>'authorSubmitButton', 'class'=> 'btn btn-success')); }}
                    </div>
                    {{ Form::close(); }}
                </div>
            </div>

            <div class="material-card" style="clear: both;">
                <div class="material-card-title">Boeken in bezit</div>
                <div class="material-card-content">
                    <table id="author-books-table" class="table">
                        <thead>
                        <tr>
                            <th>Titel</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($author->books as $book)
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
                        @foreach($author->oeuvre as $bookFromAuthor)
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

        </fieldset>
    </div>
    <script type="text/javascript">
        var author_json = {{ $author_json }};
    </script>
    {{ HTML::script('assets/js/author/author.js'); }}
@stop