<?php

class UpdateChartConfigurationFromJsonAdapter extends CreateChartConfigurationFromJsonAdapter implements UpdateChartConfigurationRequest
{

    /**
     * @var  integer
     * @required
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}