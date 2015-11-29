<?php

class AuthorRepository implements Repository{

    public function find($id, $with = array())
    {
        return Author::with($with)->find($id);
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