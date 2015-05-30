<?php
class AuthorFormValidator {

    public function createValidator(){
        $rules = array(
            'name' => 'required',
            'firstname' => 'required',
            'date_of_birth' => 'date_format:"d/m/Y"',
            'date_of_death' => 'date_format:"d/m/Y"'
        );
        $validator = Validator::make(Input::get(), $rules);

        return $validator;
    }
}