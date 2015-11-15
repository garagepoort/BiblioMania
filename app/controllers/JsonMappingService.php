<?php

class JsonMappingService
{
    private $jsonMapper;

    public function __construct()
    {
        $this->jsonMapper = new JsonMapper();
        $this->jsonMapper->bExceptionOnMissingData = true;
    }

    public function mapInputToJson($input, $mapObject){
        try{
            $jsonObject = json_decode(json_encode($input), FALSE);
            return $this->jsonMapper->map($jsonObject, $mapObject);
        }catch (JsonMapper_Exception $ex){
            throw new ServiceException($ex->getMessage(), 400, $ex);
        }
    }
}