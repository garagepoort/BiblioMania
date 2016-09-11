<?php

class ChartConfigurationRepository implements Repository
{

    public function find($id, $with = array())
    {
        return ChartConfiguration::with($with)
            ->where('id', '=', $id)
            ->first();
    }

    public function all()
    {
        return ChartConfiguration::all();
    }

    public function allFromUser($userId, $with = array())
    {
        return ChartConfiguration::with($with)
            ->where('user_id', '=', $userId)
            ->get();
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
        return Book::find($id)->delete();
    }
}