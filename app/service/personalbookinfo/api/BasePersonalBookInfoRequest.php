<?php

interface BasePersonalBookInfoRequest
{

    function getRating();

    function getReview();

    function isInCollection();

    function getReasonNotInCollection();

    /**
     * @return BuyInfoRequest
     */
    function getBuyInfo();

    /**
     * @return GiftInfoRequest
     */
    function getGiftInfo();

}