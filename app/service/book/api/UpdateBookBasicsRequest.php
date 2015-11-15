<?php

interface UpdateBookBasicsRequest
{
    function getId();

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