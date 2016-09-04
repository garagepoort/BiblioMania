<?php

/**
 * @property integer id
 * @property string filters
 * @property integer xProperty
 * @property string  type
 * @property string title
 * @property string xLabel
 * @property integer user_id
 * @property integer yProperty
 */
class ChartConfiguration extends Eloquent
{

    protected $table = 'chart_configuration';

    protected $fillable = array(
        'id',
        'title',
        'user_id',
        'type',
        'xProperty',
        'xLabel',
        'yProperty',
        'filters'
    );

}