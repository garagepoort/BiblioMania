<?php


interface BaseBookRequest
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

    function getPreferredAuthorId();

    function getImageUrl();

    function getPages();

    function getPrint();

    function getSerie();

    function getPublisherSerie();
    
    function getTranslator();

    function getSummary();

    /** @return PriceRequest */
    function getRetailPrice();
}