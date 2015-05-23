<div>
    {{ Form::label('yearsLabel', 'Jaar:', array()); }}
    <div class="">
        {{ Form::select('yearsValue', $years, '2014', array('class' => 'input-xs form-control', 'id' => $selectId)); }}
    </div>
</div>