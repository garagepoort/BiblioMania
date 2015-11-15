<?php

interface BaseBookBasicsRequest
{
    function getTitle();

    function getSubtitle();

    function getIsbn();

    function getGenre();

    function getPublisher();

    function getCountry();

    function getLanguage();

    function getTags();

    /** @return DateRequest */
    function getPublicationDate();
}