<?php

class AuthorToJsonAdapter
{
    /** @var  NameToJsonAdapter */
    private $name;
    /** @var  DateToJsonAdapter */
    private $dateOfBirth;
    /** @var  DateToJsonAdapter */
    private $dateOfDeath;

    /**
     * AuthorToJsonAdapter constructor.
     * @param Author $author
     */
    public function __construct(Author $author)
    {
        $this->name = new NameToJsonAdapter($author->firstname, $author->name, $author->infix);
        if($author->date_of_birth  != null){
            $this->dateOfBirth = new DateToJsonAdapter($author->date_of_birth);
        }
        if($author->date_of_death  != null){
            $this->dateOfDeath = new DateToJsonAdapter($author->date_of_death);
        }
    }

    public function mapToJson(){
        $result = array(
            "name" => $this->name->mapToJson()
        );
        if($this->dateOfBirth != null){
            $result['dateOfBirth'] = $this->dateOfBirth->mapToJson();
        }
        if($this->dateOfDeath != null){
            $result['dateOfDeath'] = $this->dateOfDeath->mapToJson();
        }
        return $result;
    }
}