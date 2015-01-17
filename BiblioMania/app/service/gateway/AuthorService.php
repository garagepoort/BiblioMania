<?php

class AuthorService
{

    public function saveOrUpdate($name, $infix, $firstname, $authorImage = null, $date_of_birth_id = null, $date_of_death_id = null)
    {
        $author_model = Author::where('name', '=', $name)
            ->where('firstname', '=', $firstname)
            ->where('infix', '=', $infix)
            ->first();

        if (is_null($author_model)) {
            $author_model = new Author();
        }

        $author_model->name = $name;
        $author_model->firstname = $firstname;
        $author_model->infix = $infix;

        if (!empty($date_of_birth_id)) {
            $author_model->date_of_birth_id = $date_of_birth_id;
        }else{
            $author_model->date_of_birth_id = null;
        }

        if (!empty($date_of_death_id)) {
            $author_model->date_of_death_id = $date_of_death_id;
        }else{
            $author_model->date_of_death_id = null;
        }

        if (!empty($authorImage)) {
            $author_model->image = $authorImage;
        }

        $author_model->save();
        return $author_model;
    }

}