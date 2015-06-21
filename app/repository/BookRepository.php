<?php

class BookRepository implements iRepository{

    public function find($id)
    {
        return Book::where('id', '=', $id)
            ->where('user_id', '=', Auth::user()->id)->first();
    }

    public function all()
    {
        return Book::all();
    }

    public function save($entity)
    {
        $entity->save();
    }

    public function delete($entity)
    {
        $entity->delete();
    }

    public function deleteById($id){
        return Book::find($id)->delete();
    }
}