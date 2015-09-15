<?php

class BookFormValidator {

    public function createValidatorForBasics(){
        $rules = array(
            'book_title' => 'required',
            'book_isbn' => 'required|numeric|digits:13',
            'book_publisher' => 'required',
            'book_genre' => 'required',
        );
        $validator = Validator::make(Input::get(), $rules);

        return $validator;
    }
}