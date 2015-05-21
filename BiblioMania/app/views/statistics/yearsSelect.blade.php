<div class="form-group">
    {{ Form::label('yearsLabel', 'Jaar:', array('class' => 'col-md-1', 'style' => '')); }}
    <div class="col-md-2">
        {{ Form::select('yearsValue', $years, '2014', array('class' => 'input-sm form-control', 'id' => $selectId)); }}
    </div>
</div>