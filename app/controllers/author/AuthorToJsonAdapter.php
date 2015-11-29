<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class AuthorToJsonAdapter
{
    /** @var  int */
    private $id;
    /** @var  NameToJsonAdapter */
    private $name;
    /** @var  DateToJsonAdapter */
    private $dateOfBirth;
    /** @var  DateToJsonAdapter */
    private $dateOfDeath;
    /** @var  string */
    private $image;
    /** @var  boolean */
    private $preferred;

    /**
     * AuthorToJsonAdapter constructor.
     * @param Author $author
     */
    public function __construct(Author $author)
    {
        $this->id = $author->id;
        $this->preferred = $author->preferred;
        $this->name = new NameToJsonAdapter($author->firstname, $author->name, $author->infix);
        if($author->date_of_birth  != null){
            $this->dateOfBirth = new DateToJsonAdapter($author->date_of_birth);
        }
        if($author->date_of_death  != null){
            $this->dateOfDeath = new DateToJsonAdapter($author->date_of_death);
        }
        $this->getImageFromAuthor($author);
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "name" => $this->name->mapToJson(),
            "preferred" => $this->preferred
        );
        if($this->dateOfBirth != null){
            $result['dateOfBirth'] = $this->dateOfBirth->mapToJson();
        }
        if($this->dateOfDeath != null){
            $result['dateOfDeath'] = $this->dateOfDeath->mapToJson();
        }
        if(!StringUtils::isEmpty($this->image)){
            $result['image'] = $this->image;
        }
        return $result;
    }

    private function getImageFromAuthor(Author $author)
    {
        $username = Auth::user()->username;
        $baseUrl = URL::to('/');
        if(!StringUtils::isEmpty($author->image)){
            $this->image = $baseUrl . "/authorImages/" . $author->image;
        }
    }
}