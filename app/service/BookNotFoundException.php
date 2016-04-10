<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookNotFoundException extends ServiceException {
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}