<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */
class CityController extends Controller
{

    /** @var CityService $cityService */
    private $cityService;

    function __construct()
    {
        $this->cityService = App::make('CityService');
    }

    public function getCities(){
        return array_map(function($item){
            $adapter = new CityToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->cityService->getCities()->all());
    }

}