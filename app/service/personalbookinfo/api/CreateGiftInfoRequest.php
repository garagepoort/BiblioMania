<?php

interface CreateGiftInfoRequest
{

    /**
     * @return DateRequest
     */
    function getGiftDate();

    function getReason();

    function getOccasion();

    function getFrom();
}