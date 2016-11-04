<?php

class PersonalBookInfoRepository implements Repository{

    public function find($id, $with = array())
    {
        return PersonalBookInfo::with($with)
            ->where('id', '=', $id)
            ->first();
    }

    public function findByUserAndBook($userId, $book_id){
        return PersonalBookInfo::where('book_id', '=', $book_id)
            ->where('user_id', '=', $userId)
            ->first();
    }

    public function findByUserAndId($userId, $id, $with = array()){
        return PersonalBookInfo::with($with)
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->first();
    }

    public function all()
    {
        return PersonalBookInfo::all();
    }

    public function save($entity)
    {
       $entity->save();
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }
}