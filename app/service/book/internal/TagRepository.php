<?php

class TagRepository implements Repository
{

    public function find($id, $with = array())
    {
        return Tag::where('id', '=', $id)->with($with)->first();
    }

    public function all()
    {
        return Tag::all();
    }

    public function save($entity)
    {
        $entity->save();
        return $entity;
    }

    public function delete($entity)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }

    public function syncTagsWithBook(Book $book, $tagIds){
        $book->tags()->sync($tagIds);
    }
}