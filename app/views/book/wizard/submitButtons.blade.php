<div class="control-group">
    <label class="control-label" for="bookSubmitButton"></label>
    <div class="controls">
        @if($step != 1)
            {{ Form::submit('Vorige', array('id'=>'bookNextButton', 'class'=> 'btn btn-primary', 'onclick' => "setRedirectToPrevious(); return validateForm();")); }}
        @endif
        {{ Form::submit('Volgende', array('id'=>'bookNextButton', 'class'=> 'btn btn-success', 'onclick' => 'return validateForm();')); }}
        <button style="float: right" href="{{ URL::to('getBooks') }}" class='clickableRow btn btn-danger' onclick="return false;">Annuleer</button>
    </div>
</div>