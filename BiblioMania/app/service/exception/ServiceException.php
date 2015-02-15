<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 12/02/15
 * Time: 22:35
 */

class ServiceException extends Exception {

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}