@extends('main')
@section("title")
    {{ $title }}
@endsection
@section("content")
    @include('WIZARDSERVICE::wizardsteps', array('progress' => $book_wizard_step))
    <div class="create-book-div">
        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => $currentStep->url . $book_id, 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
        <input id="redirectInput" hidden name="redirect" value="NEXT">

        <div id="error-div" class="material-card error-message" hidden>
            <div id="error-message" class="material-card-content error-message"></div>
        </div>

        <fieldset>
            @if($book_cover_image != '')
                {{ HTML::image($book_cover_image, 'image', array('style' => 'margin-bottom: 10px;')) }}
            @endif
            <div class="cover-info-top-panel">
                <!-- {{ Form::label('bookTypeOfCoverLabel', 'Cover type:', array('class' => 'col-md-2 control-label')); }} -->
                <!-- {{ $errors->first('book_typeOfCover') }} -->
                <div class="col-md-4">
                    {{ Form::select('book_type_of_cover', $covers, $book_type_of_cover, array('class' => 'input-sm form-control')); }}
                </div>
                <div>
                    <span style="margin-right: 10px">Ik wil zelf een afbeelding uploaden:</span><input
                            id="cover-info-self-upload-checkbox" type="checkbox" name="coverInfoSelfUpload"/>
                </div>
            </div>
            <!-- IMAGE -->

            <div id="cover-info-self-upload-panel" class="form-group" hidden>
                {{ Form::label('imageBookLabel', 'Cover:', array('class' => 'col-md-3 control-label')); }}
                        <!-- {{ $errors->first('book_image') }} -->
                <div class="col-md-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                             style="width: 200px; height: 150px;"></div>
                        <div>
                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span
                                    class="fileinput-exists">Change</span>{{ Form::file('book_cover_image') }}</span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>

            </div>

            <div id="cover-info-google-search-panel">
                <h3>Zoeken op:</h3>
                <table class="cover-info-filter-table">
                    <tbody>
                    <tr>
                        <td>
                            <input id="cover-info-author-search-checkbox" type="checkbox" checked/>
                        </td>
                        <td>
                            Auteur naam
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input id="cover-info-isbn-search-checkbox" type="checkbox" checked/>
                        </td>
                        <td>
                            ISBN
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input id="cover-info-title-search-checkbox" type="checkbox" checked/>
                        </td>
                        <td>
                            Titel
                        </td>
                    </tr>
                    </tbody>
                </table>

                @include('GIS::googleImageSearch', array('imageUrlInput' => 'coverInfoUrl','contentDivId' => 'coverInfoContent'))

            </div>
            @include('book/wizard/submitButtons')
        </fieldset>
        {{ Form::close(); }}
    </div>
    <script type="text/javascript">
        var authorName = "{{ $author_name }}";
        var bookTitle = "{{ $book_title }}";
        var bookIsbn = "{{ $book_isbn }}";
    </script>
    {{ HTML::script('assets/js/book/GoogleBookSearch.js'); }}
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
    {{ HTML::script('assets/js/book/wizard/cover.js'); }}
@endsection
@stop