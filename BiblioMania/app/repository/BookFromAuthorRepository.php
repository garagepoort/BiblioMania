<?php

class BookFromAuthorRepository implements iRepository{

    public function find($id)
    {
        return BookFromAuthor::find($id);
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
}