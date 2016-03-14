<?php

class ChartConfiguration extends Eloquent
{

    protected $table = 'chart_configuration';

    protected $fillable = array(
        'title',
        'user_id',
        'type',
        'xProperty',
        'yProperty'
    );

    protected $with = array('conditions');

    /**
     * @return mixed
     */
    public function conditions()
    {
        return $this->hasMany('ChartCondition', 'chart_configuration_id');
    }

}