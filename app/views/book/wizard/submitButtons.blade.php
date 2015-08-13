<div class="control-group">
    <label class="control-label" for="bookSubmitButton"></label>
    <div class="controls">
        {{ Form::submit('Vorige', array('id'=>'bookNextButton', 'class'=> 'btn btn-primary', 'onclick' => "setRedirectToPrevious(); return validateForm();")); }}
        {{ Form::submit('Volgende', array('id'=>'bookNextButton', 'class'=> 'btn btn-success', 'onclick' => 'return validateForm();')); }}
    </div>
</div>