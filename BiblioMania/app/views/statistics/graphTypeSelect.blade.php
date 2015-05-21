<div class="form-group">
    {{ Form::label('chartTypeLabel', 'Type grafiek:', array('class' => 'col-md-2', 'style' => '')); }}
    <div class="col-md-2">
        {{ Form::select('chartTypeValue', array('ColumnChart'=>'Column', 'PieChart'=>'Pie', 'BarChart'=>'Bar', 'LineChart'=>'Line'), 'ColumnChart', array('class' => 'input-sm form-control', 'id' => $selectId)); }}
    </div>
</div>