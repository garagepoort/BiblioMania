<?php

class UpdateFirstPrintFromJsonAdapter extends BaseFirstPrintFromJsonAdapter implements UpdateFirstPrintInfoRequest
{

    /** @var int */
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