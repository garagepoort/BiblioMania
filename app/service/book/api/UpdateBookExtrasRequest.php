<?php

interface UpdateBookExtrasRequest
{
    function getId();

    function getCoverPriceCurrency();

    function getCoverPrice();

    function getPrint();

    function getPages();

    function getTranslator();

    function getBookSeries();

    function getPublisherSeries();

    function getSummary();

    function getOldTags();

    function getState();

}