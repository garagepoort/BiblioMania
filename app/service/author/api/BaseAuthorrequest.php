<?php

interface BaseAuthorRequest
{
    /**
     * @return NameFromJsonAdapter
     */
    function getName();

    function getImageUrl();

    function getDateOfBirth();

    function getDateOfDeath();
}