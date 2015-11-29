<?php

class BookFromAuthorRepository implements Repository{

    public function find($id,$with = array())
    {
        return BookFromAuthor::with($with)->find($id);
    }

    public function findByTitle($author_id, $title)
    {
        return $bookFromAuthor = BookFromAuthor::where("title", "=", $title)
            ->where("author_id", "=", $author_id)
            ->first();
    }

    public function all()
    {
        return BookFromAuthor::all();
    }

    public function save($entity)
    {
        $entity->save();
    }

    public function delete($entity)
    {
        $entity->delete();
    }

    public function deleteById($id)
    {
        BookFromAuthor::find($id)->delete();
    }

    public function getFromAuthor($author_id)
    {
        return BookFromAuthor::with(array('books'))->where("author_id", "=", $author_id)->get();
    }
}