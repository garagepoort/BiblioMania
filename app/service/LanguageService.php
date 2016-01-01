<?php

class LanguageService
{
    /** @var  LanguageRepository */
    private $languageRepository;

    function __construct()
    {
        $this->languageRepository = App::make('LanguageRepository');
    }


    public function getLanguages()
    {
        return Language::all();
    }

    public function findOrCreate($languageName)
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

    public function find($id){
        return $this->languageRepository->find($id);
    }

    public function getLanguagesMap()
    {
        $result = array();
        foreach (Language::all() as $language) {
            $result[$language->language] = $language->language;
        }
        return $result;
    }

}