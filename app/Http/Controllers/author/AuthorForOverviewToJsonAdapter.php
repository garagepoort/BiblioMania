<?php

use Bendani\PhpCommon\Utils\StringUtils;

class AuthorForOverviewToJsonAdapter
{
    /** @var  int */
    private $id;
    /** @var  NameToJsonAdapter */
    private $name;
    /** @var  ImageToJsonAdapter */
    private $spriteImage;

    public function __construct(Author $author)
    {
        $this->id = $author->id;
        $this->name = new NameToJsonAdapter($author->firstname, $author->name, $author->infix);

        if(!StringUtils::isEmpty($author->image)){
            $imageToJsonAdapter = new ImageToJsonAdapter();
            $imageToJsonAdapter->fromAuthor($author);
            $this->spriteImage = $imageToJsonAdapter;
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "name" => $this->name->mapToJson()
        );
        if($this->spriteImage != null){
            $result['spriteImage'] = $this->spriteImage->mapToJson();
        }
        return $result;
    }
}