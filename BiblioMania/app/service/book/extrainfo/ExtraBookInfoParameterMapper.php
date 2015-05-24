<?php

class ExtraBookInfoParameterMapper {

    public function create(){
        return new ExtraBookInfoParameters(
            Input::get('book_number_of_pages'),
            Input::get('book_print'),
            Input::get('book_serie'),
            Input::get('book_publisher_serie'),
            Input::get('translator')
        );
    }
}