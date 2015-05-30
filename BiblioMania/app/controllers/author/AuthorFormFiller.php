<?php

class AuthorFormFiller
{

    public static function createArrayForCreate()
    {
        $result = array();
        $result['author_id'] = '';
        $result['name'] = '';
        $result['infix'] = '';
        $result['firstname'] = '';
        $result['date_of_birth_day'] = '';
        $result['date_of_birth_month'] = '';
        $result['date_of_birth_year'] = '';
        $result['date_of_death_day'] = '';
        $result['date_of_death_month'] = '';
        $result['date_of_death_year'] = '';
        return $result;
    }

    public static function createEditAuthorArray($author)
    {
        $result = array();
        $result['author_id'] = $author->id;
        $result['name'] = $author->name;
        $result['infix'] = $author->infix;
        $result['firstname'] = $author->firstname;

        if(!is_null($author->date_of_birth)){
            $result['date_of_birth_day'] = $author->date_of_birth->day;
            $result['date_of_birth_month'] = $author->date_of_birth->month;
            $result['date_of_birth_year'] = $author->date_of_birth->year;
        }
        if(!is_null($author->date_of_death)){
            $result['date_of_death_day'] = $author->date_of_death->day;
            $result['date_of_death_month'] = $author->date_of_death->month;
            $result['date_of_death_year'] = $author->date_of_death->year;
        }
        return $result;
    }
}