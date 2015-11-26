<?php

interface UpdateOeuvreItemRequest
{

    function getId();

    function getLinkedBooks();

    function getTitle();

    function getPublicationYear();

    function getAuthorId();
}