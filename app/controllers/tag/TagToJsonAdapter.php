<?php

class TagToJsonAdapter
{

    /** @var string */
    private $text;

    /**
     * TagToJsonAdapter constructor.
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->text = $tag->name;
    }


    public function mapToJson(){
        return array(
            "text"=>$this->text
        );
    }
}