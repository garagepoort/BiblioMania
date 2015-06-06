<?php

class LanguageRepository implements iRepository{

    public function find($id)
    {
        return Language::find($id);
    }

    public function all()
    {
        return Language::all();
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
        Language::find($id)->delete();
    }
}