<?php

class FirstPrintInfoRepository implements Repository
{

    public function find($id, $with = array())
    {
        return FirstPrintInfo::find($id);
    }

    public function all()
    {
        return FirstPrintInfo::all();
    }

    public function save($entity)
    {
        $entity->save();
    }

    public function delete($entity)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }
}