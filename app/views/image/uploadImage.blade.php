{{-- checkbox-name, googelImageUrlName, googleImageContentDiv, fileName --}}
<span style="margin-right: 10px">Ik wil zelf een afbeelding uploaden:</span>
<input id="upload-checkbox" type="checkbox" name="{{ $checkbox }}"/>

<div id="upload-panel" class="form-group" hidden>
    {{ Form::label('imageAuthorLabel', 'Afbeelding:', array('class' => 'col-md-3')); }}
    <div class="col-md-3">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                 style="width: 200px; height: 150px;">
            </div>
            <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span
                                        class="fileinput-exists">Change</span>{{ Form::file($file) }}</span>
                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
            </div>
        </div>
    </div>
</div>

<div id="search-panel">
    @include('googleImageSearch', array('imageUrlInput' => $imageUrlInput,'contentDivId' => $contentDivId))
</div>

<script type="text/javascript">
    $('#upload-checkbox').change(function () {
        if ($(this).is(':checked')) {
            $('#upload-panel').show(250);
            $('#search-panel').hide(250);
        } else {
            $('#upload-panel').hide(250);
            $('#search-panel').show(250);
        }
    });
</script>