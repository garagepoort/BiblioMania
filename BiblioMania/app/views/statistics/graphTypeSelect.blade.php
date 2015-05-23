<div>
    {{ Form::label('chartTypeLabel', 'Type grafiek:') }}
    <div class="">
        {{ Form::select('chartTypeValue', array('ColumnChart'=>'Column', 'PieChart'=>'Pie', 'BarChart'=>'Bar', 'LineChart'=>'Line'), 'ColumnChart', array('class' => 'input-xs form-control', 'id' => $selectId)); }}
    </div>
</div>