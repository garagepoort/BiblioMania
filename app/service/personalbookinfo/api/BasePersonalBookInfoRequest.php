<?php

interface BasePersonalBookInfoRequest
{

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