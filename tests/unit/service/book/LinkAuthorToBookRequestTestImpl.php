<?php

class LinkAuthorFromBookRequestTestImpl implements LinkAuthorToBookRequest
{

    private $authorId = 4329;

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