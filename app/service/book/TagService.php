<?php

class TagService {

    public function findOrCreate($name){
        $tag = Tag::where("name", "=", $name)->first();
        if($tag == null){
            $tag = new Tag();
            $tag->name = $name;
            $tag->save();
        }
        return $tag;
    }

    public function createTags($tagNames){
        $tags = array();
        foreach($tagNames as $tagName ){
            $tag = $this->findOrCreate($tagName);
            array_push($tags, $tag->id);
        }
        return $tags;
    }
}