<?php
use Bendani\PhpCommon\Utils\Model\StringUtils;

/**
 * Created by PhpStorm.
 * User: davidmaes
 * Date: 25/10/15
 * Time: 21:13
 */
class FirstPrintInfoJsonMapper
{
    /** @var  DateToJsonMapper $dateToJsonMapper */
    private $dateToJsonMapper;

    public function __construct()
    {
        $this->dateToJsonMapper = App::make('DateToJsonMapper');
    }


    public function mapToJson(FirstPrintInfo $firstPrintInfo){
        $jsonArray = array(
            "id" => $firstPrintInfo->id,
            "title" => $firstPrintInfo->title,
            "isbn" => $firstPrintInfo->isbn,
            "subtitle" => $firstPrintInfo->subtitle,
            "publicationDate" => $this->dateToJsonMapper->mapToJson($firstPrintInfo->publication_date),
        );
        if($firstPrintInfo->publisher !==null){
            $jsonArray['publisher'] = $firstPrintInfo->publisher->name;
        }
        if($firstPrintInfo->country !==null){
            $jsonArray['country'] = $firstPrintInfo->country->name;
        }
        if($firstPrintInfo->language !==null){
            $jsonArray['language'] = $firstPrintInfo->language->language;
        }
        return $jsonArray;
    }
}