<?php

interface UpdateOeuvreItemRequest
{

    function getId();

    function getTitle();

    function getPublicationYear();

    function getAuthorId();
}