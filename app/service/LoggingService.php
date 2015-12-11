<?php

class LoggingService
{

    private $logger;

    public function __construct(){
        $this->logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
    }

    public function logInfo($message){
        $this->logger->info($message);
    }
}