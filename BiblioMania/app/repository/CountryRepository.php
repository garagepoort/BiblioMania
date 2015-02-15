<?php

class CountryRepository implements iRepository{

    public function find($id)
    {
        return Country::find($id);
    }

    public function findFull($id){
        return Country::with('books', 'authors', 'publishers', 'first_print_infos')->find($id);
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
}