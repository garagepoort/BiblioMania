<?php

class CityRepository implements Repository{

    public function find($id, $with = array())
    {
        return City::with($with)->find($id);
    }

    public function getCity($name){
        return City::where('name', '=', $name)->first();
    }

    public function all()
    {
        return City::all();
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
        return City::find($id)->delete();
    }
}