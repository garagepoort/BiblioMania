<?php

class UnlinkAuthorToBookFromJsonAdapter implements UnlinkAuthorToBookRequest
{
    /** @var  int */
    private $authorId;

    /**
     * @return int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }


}