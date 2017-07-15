<?php

use Bendani\PhpCommon\Utils\StringUtils;

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
    /** @var  string */
    private $imageName;
    /** @var  boolean */
    private $preferred;

    /**
     * AuthorToJsonAdapter constructor.
     * @param Author $author
     */
    public function __construct(Author $author)
    {
        $this->id = $author->id;
        if($author->pivot != null){
            $this->preferred = $author->pivot->preferred == 1 ? true : false;
        }

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
            $result['imageName'] = $this->imageName;
        }
        return $result;
    }

    private function getImageFromAuthor(Author $author)
    {
        $baseUrl = URL::to('/');
        if(!StringUtils::isEmpty($author->image)){
            $this->image = $baseUrl . "/" . Config::get("properties.authorImagesLocation") . "/" . $author->image;
            $this->imageName = $author->image;
        }
    }
}