<?php

class LanguageJsonMapper
{

    public function mapToJson(Language $language){
        /** @var LanguageData $languageData */
        $languageData = new LanguageData();
        $languageData->setName($language->language);
        return $languageData->toJson();
    }

    public function mapArrayToJson($languages){
        $result = array();
        foreach($languages as $language){
            array_push($result, $this->mapToJson($language));
        }
        return $result;
    }
}