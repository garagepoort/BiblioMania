<?php

class CountryRepository implements iRepository{

    public function find($id, $with = array())
    {
        return Country::with($with)->find($id);
    }

    public function findFull($id){
        return Country::with('books', 'authors', 'first_print_infos')->find($id);
    }

    public function getCountry($name){
        return Country::where('name', '=', $name)->first();
    }

    public function all()
    {
        return Country::all();
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
        return Country::find($id)->delete();
    }
}