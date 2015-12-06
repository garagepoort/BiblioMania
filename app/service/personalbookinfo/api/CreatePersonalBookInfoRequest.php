<?php

interface CreatePersonalBookInfoRequest
{

    function getBookId();

    function getRating();

    function getReview();

    function isInCollection();

    function getReasonNotInCollection();

    /**
     * @return CreateBuyInfoRequest
     */
    function getBuyInfo();

    /**
     * @return CreateGiftInfoRequest
     */
    function getGiftInfo();

}