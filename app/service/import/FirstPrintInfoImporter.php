<?php

class FirstPrintInfoImporter
{

    public static function importFirstPrintInfo($title, $subtitle, $isbn, $countryName, $language, $publisher, $publication_date)
    {
        $country = null;
        if ($countryName != '') {
            $country = App::make('CountryService')->findOrSave($countryName);
            $country_id = $country->id;
        } else {
            $country_id = null;
        }
        $date = DateImporter::importDate($publication_date);
        $language = App::make('LanguageService')->findOrSave($language);

        return App::make('FirstPrintInfoService')->saveOrUpdate(
            $title,
            $subtitle,
            $isbn,
            $date,
            $publisher,
            $country_id,
            $language->id);
    }
}