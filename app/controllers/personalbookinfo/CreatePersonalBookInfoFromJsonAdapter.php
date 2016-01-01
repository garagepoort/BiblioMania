<?php

class UpdatePersonalBookInfoFromJsonAdapter extends BasePersonalBookInfoFromJsonAdapter implements UpdatePersonalBookInfoRequest
{
    /** @var  int */
    /** @required   */
    private $id;

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