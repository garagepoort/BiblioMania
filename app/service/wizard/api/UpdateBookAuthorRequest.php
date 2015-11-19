<?php

interface UpdateBookAuthorRequest
{
    function getId();

    /**
     * @return AuthorFromJsonAdapter
     */
    function getPreferredAuthor();

    /**
     * @return AuthorFromJsonAdapter[]
     */
    function getSecondaryAuthors();
}