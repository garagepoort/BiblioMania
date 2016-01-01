<?php

interface BaseReadingDateRequest
{

    /** @return DateRequest */
    function getDate();

    function getRating();

    function getReview();

    function getPersonalBookInfoId();
}