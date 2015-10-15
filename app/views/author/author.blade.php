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
                <div class="material-card-title">Boeken in collectie</div>
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

            @include('author.oeuvreList', array('oeuvre' => $author->oeuvre))

        </fieldset>
    </div>
    <script type="text/javascript">
        var author_json = {{ $author_json }};
    </script>
    {{ HTML::script('assets/js/author/author.js'); }}
    {{ HTML::script('assets/js/author/BookFromAuthorService.js'); }}
@stop