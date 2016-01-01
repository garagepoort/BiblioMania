<?php

interface GiftInfoRequest
{

    /**
     * @return DateRequest
     */
    function getGiftDate();

    function getReason();

    function getOccasion();

    function getFrom();
}