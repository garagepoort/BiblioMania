<?php

class ExtraBookInfoParameterMapper {

    public function create(){
        return new ExtraBookInfoParameters(
            Input::get('book_number_of_pages'),
            Input::get('book_print'),
            Input::get('book_serie'),
            Input::get('book_publisher_serie'),
            Input::get('translator'),
            Input::get('book_summary'),
            Input::get('book_state'),
            Input::get('book_old_tags')
        );
    }
}