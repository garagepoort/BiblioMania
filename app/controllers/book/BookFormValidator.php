<?php

class BookFormValidator {

    public function createValidator(){
        $rules = array(
            'book_title' => 'required',
            'book_author' => 'required',
            'book_isbn' => 'required|numeric|digits:13',
            'book_number_of_pages' => 'numeric',
            'book_print' => 'numeric',
            'book_publisher' => 'required',
            'book_genre' => 'required',
            'author_name' => 'required',
            'author_firstname' => 'required',
            'first_print_isbn' => 'numeric|digits:13',
            'first_print_publication_date' => 'date_format:"d/m/Y"'
        );
        $validator = Validator::make(Input::get(), $rules);

        return $validator;
    }
}