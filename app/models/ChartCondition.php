<?php

class ChartCondition extends Eloquent
{

    protected $table = 'chart_condition';

    protected $fillable = array(
        'name',
        'value',
        'operator'
    );

}