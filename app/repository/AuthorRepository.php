<?php

class AuthorRepository implements iRepository{

    public function find($id)
    {
        return Author::find($id);
    }

    public function all()
    {
        return Author::all();
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
        return Author::find($id)->delete();
    }

    public function getAuthorByFullName($name, $firstName, $infix){
        return Author::where('name', '=', $name)
            ->where('firstname', '=', $firstName)
            ->where('infix', '=', $infix)
            ->first();
    }
}