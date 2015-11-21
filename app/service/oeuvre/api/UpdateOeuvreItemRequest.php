<?php

interface UpdateOeuvreItemRequest
{

    function getLinkedBooks();

    function getTitle();

    function getPublicationYear();

    function getAuthorId();
}