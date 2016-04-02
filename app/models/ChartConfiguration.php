<?php

/**
 * @property integer id
 * @property string filters
 * @property integer xProperty
 * @property string  type
 * @property string title
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
        'yProperty',
        'filters'
    );

}