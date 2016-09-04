<?php

class BookSerieRepository implements Repository
{

    public function find($id, $with = array())
    {
        return Serie::where('id', '=', $id)->with($with)->first();
    }

    public function findByName($name, $with = array())
    {
        return Serie::where('name', '=', $name)->with($with)->first();
    }

    public function all()
    {
        return Serie::all();
    }

    public function save($entity)
    {
        $entity->save();
        return $entity;
    }

    public function delete($entity)
    {
        $entity->delete();
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }
}