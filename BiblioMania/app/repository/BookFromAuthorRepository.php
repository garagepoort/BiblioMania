<?php

class BookFromAuthorRepository implements iRepository{

    public function find($id)
    {
        return BookFromAuthor::find($id);
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