<?php

interface CreateAuthorRequest
{
    /**
     * @return NameFromJsonAdapter
     */
    function getName();

    function getImageUrl();

    function getDateOfBirth();

    function getDateOfDeath();
}