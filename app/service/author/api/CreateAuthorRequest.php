<?php

interface CreateAuthorRequest
{
    /**
     * @return NameFromJsonAdapter
     */
    function getName();

    function getImage();

    function getDateOfBirth();

    function getDateOfDeath();
}