<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 11/04/15
 * Time: 09:50
 */

class PublisherRepository implements iRepository{

    public function find($id)
    {
        return Publisher::find($id);
    }

    public function all()
    {
        return Publisher::all();
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
        return Publisher::find($id)->delete();
    }
}