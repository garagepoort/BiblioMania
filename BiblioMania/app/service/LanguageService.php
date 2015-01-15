<?php

class LanguageService
{

    public function getLanguages()
    {
        return Language::all();
    }

    public function findOrSave($languageName)
    {
        $language = Language::where('language', '=', $languageName)
            ->first();

        if (is_null($language)) {
            $language = new Language(array(
                'language' => $languageName,
            ));
            $language->save();
        }
        return $language;
    }

    public function getLanguagesMap()
    {
        $result = array();
        foreach (Language::all() as $language) {
            $result[$language->id] = $language->language;
        }
        return $result;
    }

}