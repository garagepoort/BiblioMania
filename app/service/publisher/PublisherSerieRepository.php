<?php

class PublisherSerieRepository implements Repository
{

    public function find($id, $with = array())
    {
        return PublisherSerie::where('id', '=', $id)->with($with)->first();
    }

    public function findByName($name, $with = array())
    {
        return PublisherSerie::where('name', '=', $name)->with($with)->first();
    }

    public function all()
    {
        return PublisherSerie::all();
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