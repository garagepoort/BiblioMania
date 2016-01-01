<?php

interface BaseFirstPrintInfoRequest
{

    function getTitle();

    function getSubtitle();

    function getIsbn();

    function getPublisher();

    function getCountry();

    function getLanguage();

    /** @return DateRequest */
    function getPublicationDate();

}