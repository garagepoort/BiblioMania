<?php

class LanguageService {

    public function getLanguages(){
        return Language::all();
    }

}