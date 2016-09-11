<?php


class UpdateFirstPrintInfoRequestTestImpl extends BaseFirstPrintInfoRequestTestImpl implements UpdateFirstPrintInfoRequest
{

    private $id = 839;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}