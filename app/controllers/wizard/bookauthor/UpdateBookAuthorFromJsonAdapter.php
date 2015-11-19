<?php

class UpdateBookAuthorFromJsonAdapter implements UpdateBookAuthorRequest
{

    /**
     * @var integer
     * @required
     */
    private $id;
    /**
     * @var AuthorFromJsonAdapter
     * @required
     */
    private $preferredAuthor;
    /**
     * @var AuthorFromJsonAdapter[]
     */
    private $secondaryAuthors;

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

    /**
     * @return CreateAuthorRequest
     */
    public function getPreferredAuthor()
    {
        return $this->preferredAuthor;
    }

    /**
     * @param AuthorFromJsonAdapter $preferredAuthor
     */
    public function setPreferredAuthor($preferredAuthor)
    {
        $this->preferredAuthor = $preferredAuthor;
    }

    /**
     * @return AuthorFromJsonAdapter[]
     */
    public function getSecondaryAuthors()
    {
        return $this->secondaryAuthors;
    }

    /**
     * @param AuthorFromJsonAdapter[] $secondaryAuthors
     */
    public function setSecondaryAuthors($secondaryAuthors)
    {
        $this->secondaryAuthors = $secondaryAuthors;
    }

}