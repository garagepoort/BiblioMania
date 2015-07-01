<div class="tab-container ">
    <fieldset>

        <legend>Cover info</legend>
        @if($book_cover_image != '')
        {{ HTML::image($book_cover_image, 'image', array('style' => 'margin-bottom: 10px;')) }}
        @endif
        <div class="cover-info-top-panel">
            <!-- {{ Form::label('bookTypeOfCoverLabel', 'Cover type:', array('class' => 'col-md-2')); }} -->
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
            {{ Form::label('imageBookLabel', 'Cover:', array('class' => 'col-md-3')); }}
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

            @include('googleImageSearch', array('imageUrlInput' => 'coverInfoUrl','contentDivId' => 'coverInfoContent'))
        </div>
    </fieldset>
    {{ HTML::script('assets/js/createBook/coverInfo.js'); }}
</div>